<?php

namespace AppBundle\Controller;

use AppBundle\Database\Database;
use AppBundle\Generator\TokenGenerator;
use DateTime;
use Exception;

class IndexController
{
    private $pdo;
    private $dateTimeNow;

    public function __construct()
    {
        $this->pdo = (new Database)->getAppPdo();
        $this->dateTimeNow = new DateTime;
    }

    /**
     * @throws Exception
     */
    public function indexAction()
    {
        $this->getOrCreateUserByUsername('Foo');
        $this->showCurrentDateTime();
    }

    /**
     * @param $username
     * @throws Exception
     */
    private function getOrCreateUserByUsername($username)
    {
        $smt = $this->pdo->prepare(
            "SELECT `id`, `username`, `created_datetime` FROM `user` WHERE `username`=:username"
        );
        $smt->execute([
            'username' => $username,
        ]);
        $user = $smt->fetch();
        if ($user) {
            echo '<h1>Existing user found</h1><pre>' . print_r($user, true) . '</pre>';
            return;
        }

        $smt = $this->pdo->prepare(
            "INSERT INTO `user` SET `id`=:id, `username`=:username, `created_datetime`=:created_datetime"
        );
        $id = (new TokenGenerator)->generate();
        $user = [
            'id' => $id,
            'username' => $username,
            'created_datetime' => $this->dateTimeNow->format('Y-m-d H:i:s'),
        ];
        $smt->execute($user);
        echo "
            <h1>New user created</h1><p>Now try reloading the page.</p>
        ";
    }

    private function showCurrentDateTime()
    {
        $formattedDateTime = $this->dateTimeNow->format('Y-m-d H:i:s');
        echo "
            <p>
                The date and time of this page load&mdash;based on the <code>php.ini</code> configuration&mdash;was
                <strong>$formattedDateTime</strong>.
            </p>
        ";
    }
}
