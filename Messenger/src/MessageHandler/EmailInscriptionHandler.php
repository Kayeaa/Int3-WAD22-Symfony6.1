<?php

namespace App\MessageHandler;

use App\Message\EmailInscription;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EmailInscriptionHandler {
    
    private UserRepository $userRepository;

    public function __construct(UserRepository $rep){

        $this->userRepository = $rep;
    }

    // on fait appel à ce handler depuis le controller RegistrationController
    public function __invoke(EmailInscription $emailInscription)
    {
        $user = $this->userRepository->find ($emailInscription->getUserId());
        sleep (15);
        dd ("on envoie un mail en prennant les données d'un user");
    }

}