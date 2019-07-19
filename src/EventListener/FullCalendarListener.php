<?php

namespace App\EventListener;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListener
{
    private $sessionRepository;
    private $router;

    public function __construct(
        BookingRepository $sessionRepository,
        UrlGeneratorInterface $router
    ) {
        $this->sessionRepository = $sessionRepository;
        $this->router = $router;
    }

    public function loadEvents(CalendarEvent $calendar): void
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change b.beginAt by your start date in your custom entity
        $sessions = $this->sessionRepository
            ->createQueryBuilder('session')
            ->where('session.beginAt BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($sessions as $session) {
            // this create the events with your own entity (here session entity) to populate calendar
            $sessionEvent = new Event(
                $session->getTitle(),
                $session->getBeginAt(),
                $session->getEndAt() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Optional calendar event settings
             *
             * For more information see : Toiba\FullCalendarBundle\Entity\Event
             * and : https://fullcalendar.io/docs/event-object
             */
            // $sessionEvent->setUrl('http://www.google.com');
            // $sessionEvent->setBackgroundColor($session->getColor());
            // $sessionEvent->setCustomField('borderColor', $session->getColor());

            $sessionEvent->setUrl(
                $this->router->generate('session_show', [
                    'id' => $session->getId(),
                ])
            );

            // finally, add the session to the CalendarEvent for displaying on the calendar
            $calendar->addEvent($sessionEvent);
        }
    }
}