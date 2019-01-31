<?php
declare(strict_types=1);
/** be strict for parameter types, https://www.quora.com/Are-strict_types-in-PHP-7-not-a-bad-idea */

namespace DrdPlus\Tests\AttackSkeleton;

use DrdPlus\AttackSkeleton\PossibleArmaments;
use DrdPlus\AttackSkeleton\AttackController;
use DrdPlus\AttackSkeleton\CurrentArmamentsValues;
use DrdPlus\AttackSkeleton\CurrentProperties;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Codes\ItemHoldingCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Properties\Body\HeightInCm;
use DrdPlus\Properties\Body\Size;
use Granam\Tests\Tools\TestWithMockery;
use Mockery\MockInterface;

/**
 * @runTestsInSeparateProcesses because of affected global variables
 */
class TemplatesTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_use_template_to_add_custom_melee_weapon(): void
    {
        $this->I_can_use_template_to_add_custom_armament(__DIR__ . '/../../../parts/attack-skeleton/add-custom/add_custom_melee_weapon.php');
    }

    private function I_can_use_template_to_add_custom_armament(string $templatePath): void
    {
        $controller = $this->createAttackController();
        $controller->shouldReceive('getLocalUrlWithQuery')
            ->atLeast()->once()
            ->with([AttackController::ACTION => ''])
            ->andReturn('');
        \ob_start();
        /** @noinspection PhpIncludeInspection */
        include $templatePath;
        $content = \ob_get_clean();
        self::assertNotEmpty($content);
    }

    /**
     * @return AttackController|MockInterface
     */
    private function createAttackController(): AttackController
    {
        $controller = $this->mockery(AttackController::class);
        $controller->shouldReceive('getGenericPartsRoot')
            ->andReturn($this->getGenericPartsRoot());
        $controller->makePartial(); // call original methods in not mocked

        return $controller;
    }

    private function getGenericPartsRoot(): string
    {
        return __DIR__ . '/../../../parts/attack-skeleton';
    }

    /**
     * @test
     */
    public function I_can_use_template_to_add_custom_ranged_weapon(): void
    {
        $this->I_can_use_template_to_add_custom_armament(__DIR__ . '/../../../parts/attack-skeleton/add-custom/add_custom_ranged_weapon.php');
    }

    /**
     * @test
     */
    public function I_can_use_template_to_add_custom_body_armor(): void
    {
        $this->I_can_use_template_to_add_custom_armament(__DIR__ . '/../../../parts/attack-skeleton/add-custom/add_custom_body_armor.php');
    }

    /**
     * @test
     */
    public function I_can_use_template_to_add_custom_helm(): void
    {
        $this->I_can_use_template_to_add_custom_armament(__DIR__ . '/../../../parts/attack-skeleton/add-custom/add_custom_helm.php');
    }

    /**
     * @test
     */
    public function I_can_use_template_to_add_custom_shield(): void
    {
        $this->I_can_use_template_to_add_custom_armament(__DIR__ . '/../../../parts/attack-skeleton/add-custom/add_custom_shield.php');
    }

    /**
     * @test
     */
    public function I_can_use_template_with_armors(): void
    {
        $controller = $this->createAttackController();
        $controller->shouldReceive('isAddingNewBodyArmor')
            ->andReturn(false);
        $controller->shouldReceive('getCurrentValues')
            ->andReturn($currentValues = $this->mockery(CurrentArmamentsValues::class));
        $currentValues->shouldReceive('getCustomBodyArmorsValues')
            ->andReturn([]);
        $controller->shouldReceive('getLocalUrlWithQuery')
            ->zeroOrMoreTimes()
            ->with([AttackController::ACTION => AttackController::ADD_NEW_BODY_ARMOR])
            ->andReturn('');
        $controller->shouldReceive('getBodyArmors')
            ->andReturn([]);
        $controller->shouldReceive('getMessagesAboutArmors')
            ->andReturn([]);
        \ob_start();
        include __DIR__ . '/../../../parts/attack-skeleton/armor.php';
        $content = \ob_get_clean();
        self::assertNotEmpty($content);
        self::assertSame($content, $controller->getArmorContent());
    }

    /**
     * @test
     */
    public function I_can_use_template_with_helms(): void
    {
        $controller = $this->createAttackController();
        $controller->shouldReceive('isAddingNewHelm')
            ->andReturn(false);
        $controller->shouldReceive('getCurrentValues')
            ->andReturn($currentValues = $this->mockery(CurrentArmamentsValues::class));
        $currentValues->shouldReceive('getCustomHelmsValues')
            ->andReturn([]);
        $controller->shouldReceive('getLocalUrlWithQuery')
            ->zeroOrMoreTimes()
            ->with([AttackController::ACTION => AttackController::ADD_NEW_HELM])
            ->andReturn('');
        $controller->shouldReceive('getHelms')
            ->andReturn([]);
        $controller->shouldReceive('getMessagesAboutHelms')
            ->andReturn([]);
        \ob_start();
        include __DIR__ . '/../../../parts/attack-skeleton/helm.php';
        $content = \ob_get_clean();
        self::assertNotEmpty($content);
        self::assertSame($content, $controller->getHelmContent());
    }

    /**
     * @test
     */
    public function I_can_use_template_with_body_properties(): void
    {
        $controller = $this->createAttackController();
        $controller->shouldReceive('getCurrentProperties')
            ->andReturn($currentProperties = $this->mockery(CurrentProperties::class));
        $currentProperties->shouldReceive('getCurrentStrength')
            ->andReturn(Strength::getIt(123));
        $currentProperties->shouldReceive('getCurrentAgility')
            ->andReturn(Agility::getIt(456));
        $currentProperties->shouldReceive('getCurrentKnack')
            ->andReturn(Knack::getIt(789));
        $currentProperties->shouldReceive('getCurrentIntelligence')
            ->andReturn(Intelligence::getIt(167));
        $currentProperties->shouldReceive('getCurrentWill')
            ->andReturn(Will::getIt(-80));
        $currentProperties->shouldReceive('getCurrentCharisma')
            ->andReturn(Charisma::getIt(99));
        $currentProperties->shouldReceive('getCurrentHeightInCm')
            ->andReturn(HeightInCm::getIt(15));
        $currentProperties->shouldReceive('getCurrentSize')
            ->andReturn(Size::getIt(5));
        \ob_start();
        include __DIR__ . '/../../../parts/attack-skeleton/body_properties.php';
        $content = \ob_get_clean();
        self::assertNotEmpty($content);
        $controller->shouldReceive('getGenericPartsRoot')
            ->andReturn($this->getGenericPartsRoot());
        self::assertSame($content, $controller->getBodyPropertiesContent());
    }

    /**
     * @test
     */
    public function I_can_use_template_with_melee_weapons(): void
    {
        $controller = $this->createAttackController();
        $controller->shouldReceive('isAddingNewMeleeWeapon')
            ->andReturn(false);
        $controller->shouldReceive('getAttack')
            ->andReturn($attack = $this->mockery(PossibleArmaments::class));
        $attack->shouldReceive('getCurrentMeleeWeapon')
            ->andReturn(MeleeWeaponCode::getIt(MeleeWeaponCode::HAND));
        $controller->shouldReceive('getCurrentValues')
            ->andReturn($currentValues = $this->mockery(CurrentArmamentsValues::class));
        $currentValues->shouldReceive('getCustomMeleeWeaponsValues')
            ->andReturn([]);
        $controller->shouldReceive('getLocalUrlWithQuery')
            ->zeroOrMoreTimes()
            ->with([AttackController::ACTION => AttackController::ADD_NEW_MELEE_WEAPON])
            ->andReturn('');
        $controller->shouldReceive('getMeleeWeapons')
            ->andReturn([]);
        $attack->shouldReceive('getCurrentMeleeWeaponHolding')
            ->andReturn(ItemHoldingCode::getIt(ItemHoldingCode::MAIN_HAND));
        $controller->shouldReceive('getMessagesAboutMeleeWeapons')
            ->andReturn([]);
        \ob_start();
        include __DIR__ . '/../../../parts/attack-skeleton/melee_weapon.php';
        $content = \ob_get_clean();
        self::assertNotEmpty($content);
        self::assertSame($content, $controller->getMeleeWeaponContent());
    }

    /**
     * @test
     */
    public function I_can_use_template_with_ranged_weapons(): void
    {
        $controller = $this->createAttackController();
        $controller->shouldReceive('isAddingNewRangedWeapon')
            ->andReturn(false);
        $controller->shouldReceive('getAttack')
            ->andReturn($attack = $this->mockery(PossibleArmaments::class));
        $attack->shouldReceive('getCurrentRangedWeapon')
            ->andReturn(RangedWeaponCode::getIt(RangedWeaponCode::SAND));
        $controller->shouldReceive('getCurrentValues')
            ->andReturn($currentValues = $this->mockery(CurrentArmamentsValues::class));
        $currentValues->shouldReceive('getCustomRangedWeaponsValues')
            ->andReturn([]);
        $controller->shouldReceive('getLocalUrlWithQuery')
            ->zeroOrMoreTimes()
            ->with([AttackController::ACTION => AttackController::ADD_NEW_RANGED_WEAPON])
            ->andReturn('');
        $controller->shouldReceive('getRangedWeapons')
            ->andReturn([]);
        $attack->shouldReceive('getCurrentRangedWeaponHolding')
            ->andReturn(ItemHoldingCode::getIt(ItemHoldingCode::MAIN_HAND));
        $controller->shouldReceive('getMessagesAboutRangedWeapons')
            ->andReturn([]);
        \ob_start();
        include __DIR__ . '/../../../parts/attack-skeleton/ranged_weapon.php';
        $content = \ob_get_clean();
        self::assertNotEmpty($content);
        self::assertSame($content, $controller->getRangedWeaponContent());
    }

    /**
     * @test
     */
    public function I_can_use_template_with_shields(): void
    {
        $controller = $this->createAttackController();
        $controller->shouldReceive('isAddingNewShield')
            ->andReturn(false);
        $controller->shouldReceive('getAttack')
            ->andReturn($attack = $this->mockery(PossibleArmaments::class));
        $attack->shouldReceive('getCurrentShield')
            ->andReturn(ShieldCode::getIt(ShieldCode::WITHOUT_SHIELD));
        $controller->shouldReceive('getCurrentValues')
            ->andReturn($currentValues = $this->mockery(CurrentArmamentsValues::class));
        $currentValues->shouldReceive('getCustomShieldsValues')
            ->andReturn([]);
        $controller->shouldReceive('getLocalUrlWithQuery')
            ->zeroOrMoreTimes()
            ->with([AttackController::ACTION => AttackController::ADD_NEW_SHIELD])
            ->andReturn('');
        $controller->shouldReceive('getShields')
            ->andReturn([]);
        $attack->shouldReceive('getCurrentShieldHolding')
            ->andReturn(ItemHoldingCode::getIt(ItemHoldingCode::MAIN_HAND));
        $controller->shouldReceive('getMessagesAboutShields')
            ->andReturn([]);
        \ob_start();
        include __DIR__ . '/../../../parts/attack-skeleton/shield.php';
        $content = \ob_get_clean();
        self::assertNotEmpty($content);
        self::assertSame($content, $controller->getShieldContent());
    }
}