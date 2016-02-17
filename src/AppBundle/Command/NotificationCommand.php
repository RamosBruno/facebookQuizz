<?php

namespace AppBundle\Command;


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

        if(!empty($quizz) && !empty($users)) {
            foreach($users as $user) {
                if($em->getRepository('AppBundle:QuizzParticipation')->getParticipationByUser($user->getId(), $quizz->getId())) {
                    $template = 'Code Quizz vous informe que le quizz ' . $quizz->getName() . ' est terminé ! Venez découvrir si vous avez gagné !';
                    $sm->sendNotifications($user, $template);
                    $output->writeln('<info>Notifications send</info>');
                }
            }
        } else {
            $output->writeln('<error>No finished quizz today</error>');
        }

    }
}