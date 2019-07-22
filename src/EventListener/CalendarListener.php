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
        dump($filters['formateur']);
        // Modify the query to fit to your entity and needs
        // Change session.beginAt by your start date property
        if (array_key_exists('formateur', $filters))
        {
            $sessions = $this->sessionRepository
            ->createQueryBuilder('session')
            ->innerJoin('session.composer', 'co')
            ->innerJoin('co.module', 'm')
            ->innerJoin('m.categorie', 'c')
            ->innerJoin('c.formateurs', 'f')
            ->where('session.dateDebut BETWEEN :start and :end OR :end BETWEEN session.dateDebut and session.dateFin')
            ->andWhere('f.id = :id')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->setParameter('id', $filters['formateur'])
            ->getQuery()
            ->getResult()
        ;
        }
        else
        {
            $sessions = $this->sessionRepository
            ->createQueryBuilder('session')
            ->where('session.dateDebut BETWEEN :start and :end')
            ->orWhere('session.dateFin BETWEEN :start and :end')
            ->orWhere(':end BETWEEN session.dateDebut and session.dateFin')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;
        }

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
                'backgroundColor' => 'red',
                'borderColor' => 'red',
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