<?php

namespace App\EventListener;

use App\Entity\Session;
use App\Repository\SessionRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;

class CalendarListener
{
    private $sessionRepository;
    private $router;

    public function __construct(
        SessionRepository $sessionRepository,
        UrlGeneratorInterface $router
    ) {
        $this->sessionRepository = $sessionRepository;
        $this->router = $router;
    }

    public function load(CalendarEvent $calendar): void
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change session.beginAt by your start date property
        $sessions = $this->sessionRepository
            ->createQueryBuilder('session')
            ->where('session.dateDebut BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($sessions as $session) {
            // this create the events with your data (here session data) to fill calendar
            $sessionEvent = new Event(
                $session->getIntitule(),
                $session->getDateDebut(),
                $session->getDateFin() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $sessionEvent->setOptions([
                'backgroundColor' => 'blue',
                'borderColor' => 'blue',
            ]);
            $sessionEvent->addOption(
                'url',
                $this->router->generate('show_session', [
                    'id' => $session->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($sessionEvent);
        }
    }
}