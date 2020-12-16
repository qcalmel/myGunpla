<?php

namespace App\DataFixtures;

use App\Entity\CategoryTag;
use App\Entity\Grade;
use App\Entity\Model;
use App\Entity\ModelColor;
use App\Entity\Serie;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Scale;
use App\Entity\Unit;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $gundam00 = new Serie();
        $gundam00->setName('Mobile Suit Gundam 00')
            ->setNameShort('00');
        $manager->persist($gundam00);

        $gundamSeed = new Serie();
        $gundamSeed->setName('Mobile Suit Gundam SEED')
            ->setNameShort('SEED');
        $manager->persist($gundamSeed);

        $gundamIBO = new Serie();
        $gundamIBO->setName('Mobile Suit Gundam Iron-Blooded Orphans')
            ->setNameShort('IBO');
        $manager->persist($gundamIBO);

        $scale144 = new Scale();
        $scale144->setName('1/144');
        $manager->persist($scale144);

        $scale100 = new Scale();
        $scale100->setName('1/100');
        $manager->persist($scale100);

        $scale60 = new Scale();
        $scale60->setName('1/60');
        $manager->persist($scale60);

        $scale45 = new Scale();
        $scale45->setName('1/45');
        $manager->persist($scale45);

        $scale550 = new Scale();
        $scale550->setName('1/550');
        $manager->persist($scale550);

        $gradeNG = new Grade();
        $gradeNG->setName('No Grade')
            ->setNameShort('NG')
            ->addAllowedScale($scale144)
            ->addAllowedScale($scale100)
            ->addAllowedScale($scale60)
            ->addAllowedScale($scale45);
        $manager->persist($gradeNG);

        $gradeHG = new Grade();
        $gradeHG->setName('High Grade')
            ->setNameShort('HG')
            ->addAllowedScale($scale144)
            ->addAllowedScale($scale550);
        $manager->persist($gradeHG);

        $gradeRG = new Grade();
        $gradeRG->setName('Real Grade')
            ->setNameShort('RG')
            ->addAllowedScale($scale144);
        $manager->persist($gradeRG);

        $gradeMG = new Grade();
        $gradeMG->setName('Master Grade')
            ->setNameShort('MG')
            ->addAllowedScale($scale100);
        $manager->persist($gradeMG);

        $gradePG = new Grade();
        $gradePG->setName('Perfect Grade')
            ->setNameShort('PG')
            ->addAllowedScale($scale60);
        $manager->persist($gradePG);

        $colorRed = new ModelColor();
        $colorRed->setName('Rouge');
        $manager->persist($colorRed);

        $colorBlue = new ModelColor();
        $colorBlue->setName('Bleu');
        $manager->persist($colorBlue);

        $colorWhite = new ModelColor();
        $colorWhite->setName('Blanc');
        $manager->persist($colorWhite);

        $colorYellow = new ModelColor();
        $colorYellow->setName('Jaune');
        $manager->persist($colorYellow);

        $colorGreen = new ModelColor();
        $colorGreen->setName('Vert');
        $manager->persist($colorGreen);

        $colorGrey = new ModelColor();
        $colorGrey->setName('Gris');
        $manager->persist($colorGrey);

        $colorBlack = new ModelColor();
        $colorBlack->setName('Noir');
        $manager->persist($colorBlack);

        $tagCategorySpecial = new CategoryTag();
        $tagCategorySpecial->setName('Spécial');
        $manager->persist($tagCategorySpecial);

        $tagCategoryConversion = new CategoryTag();
        $tagCategoryConversion->setName('Conversion');
        $manager->persist($tagCategoryConversion);

        $tagCategoryWeapon = new CategoryTag();
        $tagCategoryWeapon->setName('Équipement');
        $manager->persist($tagCategoryWeapon);

        $tagCategoryColor = new CategoryTag();
        $tagCategoryColor->setName('Couleur');
        $manager->persist($tagCategoryColor);

        $tagCategoryExclusive = new CategoryTag();
        $tagCategoryExclusive->setName('Exclusif');
        $manager->persist($tagCategoryExclusive);

        $tagCategoryOption = new CategoryTag();
        $tagCategoryOption->setName('Optionnel');
        $manager->persist($tagCategoryOption);

        $tagCategoryTransformation = new CategoryTag();
        $tagCategoryTransformation->setName('Transformation');
        $manager->persist($tagCategoryTransformation);

        $tagPBandai = new Tag();
        $tagPBandai->setName('Premium Bandai')
            ->setCategory($tagCategoryExclusive);
        $manager->persist($tagPBandai);

        $tagClearColor = new Tag();
        $tagClearColor->setName('Clear Color')
            ->setCategory($tagCategoryColor);
        $manager->persist($tagClearColor);

        $tagOption = new Tag();
        $tagOption->setName('Partie(s) Optionnelle(s)')
            ->setCategory($tagCategoryOption);
        $manager->persist($tagOption);

        $tagLightning = new Tag();
        $tagLightning->setName('Éclairage LED')
            ->setCategory($tagCategorySpecial);
        $manager->persist($tagLightning);

        $tagSword = new Tag();
        $tagSword->setName('Épée')
            ->setCategory($tagCategoryWeapon);
        $manager->persist($tagSword);

        $tagBeamSaber = new Tag();
        $tagBeamSaber->setName('Sabre Laser')
            ->setCategory($tagCategoryWeapon);
        $manager->persist($tagBeamSaber);

        $tagMace = new Tag();
        $tagMace->setName('Masse')
            ->setCategory($tagCategoryWeapon);
        $manager->persist($tagMace);

        $tagBeamRifle = new Tag();
        $tagBeamRifle->setName('Fusil Laser')
            ->setCategory($tagCategoryWeapon);
        $manager->persist($tagBeamRifle);

        $tagBackpack = new Tag();
        $tagBackpack->setName('Backpack')
            ->setCategory($tagCategoryWeapon);
        $manager->persist($tagBackpack);

        $tagShield = new Tag();
        $tagShield->setName('Bouclier')
            ->setCategory($tagCategoryWeapon);
        $manager->persist($tagShield);

        $unitExia = new Unit();
        $unitExia->setName('Gundam Exia')
            ->addSerie($gundam00);
        $manager->persist($unitExia);

        $unitBarbatos = new Unit();
        $unitBarbatos->setName('Gundam Barbatos')
            ->addSerie($gundamIBO);
        $manager->persist($unitBarbatos);


        $modelBarbatos = new Model();
        $modelBarbatos->setName('Gundam Barbatos')
        ->setGradeNumber(212)
        ->setNbPart(300)
        ->setPrice(4500)
        ->setDate(new \DateTime('12/01/2019'))
        ->setScale($scale100)
            ->setGrade($gradeMG)
        ->addTag($tagMace)
        ->addPrimaryColor($colorWhite)
        ->addSecondaryColor($colorBlue)
        ->addSecondaryColor($colorYellow)
        ->addSecondaryColor($colorRed)
        ->addUnit($unitBarbatos);
        $manager->persist($modelBarbatos);

        $modelExia = new Model();
        $modelExia->setName('Gundam Exia Extra Finish Ver.')
            ->setGrade($gradeRG)
            ->setGradeNumber('Limitée')
            ->setNbPart(300)
            ->setPrice(4860)
            ->setDate(new \DateTime('11/21/2014'))
            ->setScale($scale144)
            ->addTag($tagShield)
            ->addTag($tagSword)
            ->addTag($tagBeamSaber)
            ->addTag($tagPBandai)
            ->addPrimaryColor($colorWhite)
            ->addPrimaryColor($colorBlue)
            ->addSecondaryColor($colorYellow)
            ->addSecondaryColor($colorRed)
            ->addSecondaryColor($colorGreen)
            ->addSecondaryColor($colorGrey)
            ->addUnit($unitExia);
        $manager->persist($modelExia);


        $manager->flush();
    }
}
