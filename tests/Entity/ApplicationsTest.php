<?php

namespace App\Tests\Entity;

use App\Entity\Applications;
use App\Entity\User;
use PHPUnit\Framework\TestCase;


/**
 * @author YohannHommet <yohann.hommet@outlook.fr>
 *
 * Class ApplicationsTest
 * @package App\Tests\Entity
 */
class ApplicationsTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        // set new application 
        $application = new Applications();
        
        $application->setNomEntreprise('nomEntreprise');
        $application->setLocalisationEntreprise('localisationEntreprise');
        $application->setPosteRecherche("posteRecherche");
        $application->setNatureCandidature("natureCandidature");
        $application->setDateCandidature(new \DateTime("2021-01-01"));
        $application->setLienCandidature("www.google.com");
        $application->setEmailContact("john@doe.com");
        $application->setTechnos("PHP, Java, C#");
        $application->setRemarques("Remarques");
        $application->setUser(new User);

        $this->assertEquals('nomEntreprise',             $application->getNomEntreprise());
        $this->assertEquals('localisationEntreprise',    $application->getLocalisationEntreprise());
        $this->assertEquals('posteRecherche',            $application->getPosteRecherche());
        $this->assertEquals('natureCandidature',         $application->getNatureCandidature());
        $this->assertEquals(new \DateTime("2021-01-01"), $application->getDateCandidature());
        $this->assertEquals('www.google.com',            $application->getLienCandidature());
        $this->assertEquals('john@doe.com',              $application->getEmailContact());
        $this->assertEquals('PHP, Java, C#',             $application->getTechnos());
        $this->assertEquals('Remarques',                 $application->getRemarques());
        $this->assertEquals(new User,                             $application->getUser());
    }
}



