<?php

namespace AppBundle\Command;


use AppBundle\Entity\Win;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NotificationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('quizz:notification')
            ->setDescription('Notify particpants of the end of a quizz')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $sm = $this->getContainer()->get('facebook');
        $today = new \DateTime();
        $today->setTime(0,0);
        $quizz = $em->getRepository('AppBundle:Quizz')->findOneBy(array(
            "dateEnd" => $today,
            "active" => true
        ));
        $users = $em->getRepository('AppBundle:DataUserFacebook')->findAll();

        $score_users = [];

        if(!empty($quizz) && !empty($users)) {
            foreach($users as $user) {
                if($em->getRepository('AppBundle:QuizzParticipation')->getParticipationByUser($user->getId(), $quizz->getId())) {

                    $participations = $em->getRepository('AppBundle:QuizzParticipation')->findBy([
                        "quizz" => $quizz->getId(),
                        "dataUserFacebook" => $user->getId()
                    ]);
                    $nbQuestion = $quizz->getNbQuestion();
                    $countdown = $quizz->getCountdown()->format('s');

                    $valid = 0;
                    $time = 0;

                    foreach($participations as $participation){
                        $valid += intval($participation->getValid());
                        $time += intval($participation->getCountdown()->format('s'));
                    }

                    $avgTime = $time/($nbQuestion*$countdown);
                    $score = $valid + $avgTime * $valid;
                    $score_users[$user->getId()] = $score;

                    $quizz->setActive(0);
                    $em->flush($quizz);

                    $template = 'Code Quizz vous informe que le quizz ' . $quizz->getName() . ' est terminé ! Venez découvrir si vous avez gagné !';
                    $sm->sendNotifications($user, $template);
                    $output->writeln('<info>Notifications send</info>');
                }
            }
            $winners = $quizz->getNumberOfWinner();
            arsort($score_users);

            $i = 0;
            foreach(array_keys($score_users) as $value) {
                if($i < $winners) {
                    $win = new Win();
                    $win->setQuizz($quizz->getId());
                    $win->setDataUserFacebook($value);
                    $em->persist($win);
                    $em->flush($win);
                    $i++;
                }
            }

        } else {
            $output->writeln('<error>No finished quizz today</error>');
        }

    }
}