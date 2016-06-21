<?php
namespace AppCoreBundle\Application\Impl;

use AppCoreBundle\Application\Contract\IContactService;
use AppCoreBundle\Domain\Contract\IContactRepository;
use AppCoreBundle\Infraestructure\Impl\ContactRepository;

class ContactService implements IContactService {

    private $contactRepository;

    public function __construct(ContactRepository $contactRepository) {
        $this->contactRepository = $contactRepository;
    }

    public function create() {
        die("ContactService");
    }
}