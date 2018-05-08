<?php
declare(strict_types=1);
/** be strict for parameter types, https://www.quora.com/Are-strict_types-in-PHP-7-not-a-bad-idea */

namespace DrdPlus\Tests\Calculators;

use DrdPlus\Calculator\AttackSkeleton\AttackForCalculator;
use DrdPlus\Calculator\AttackSkeleton\Controller;
use DrdPlus\Calculator\AttackSkeleton\CurrentAttackValues;
use DrdPlus\Calculator\AttackSkeleton\CurrentProperties;
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

class TemplatesTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_use_template_to_add_custom_melee_weapon(): void
    {
        $this->I_can_use_template_to_add_custom_armament(__DIR__ . '/../../../parts/add_custom_melee_weapon.php');
    }

    private function I_can_use_template_to_add_custom_armament(string $templatePath): void
    {
        $controller = $this->mockery(Controller::class);
        $controller->shouldReceive('getCurrentUrlWithQuery')
            ->atLeast()->once()
            ->with([Controller::ACTION => ''])
            ->andReturn('');
        \ob_start();
        include $templatePath;
        $content = \ob_get_clean();
        self::assertNotEmpty($content);
    }

    /**
     * @test
     */
    public function I_can_use_template_to_add_custom_ranged_weapon(): void
    {
        $this->I_can_use_template_to_add_custom_armament(__DIR__ . '/../../../parts/add_custom_ranged_weapon.php');
    }

    /**
     * @test
     */
    public function I_can_use_template_to_add_custom_body_armor(): void
    {
        $this->I_can_use_template_to_add_custom_armament(__DIR__ . '/../../../parts/add_custom_body_armor.php');
    }

    /**
     * @test
     */
    public function I_can_use_template_to_add_custom_helm(): void
    {
        $this->I_can_use_template_to_add_custom_armament(__DIR__ . '/../../../parts/add_custom_helm.php');
    }

    /**
     * @test
     */
    public function I_can_use_template_to_add_custom_shield(): void
    {
        $this->I_can_use_template_to_add_custom_armament(__DIR__ . '/../../../parts/add_custom_shield.php');
    }

    /**
     * @test
     */
    public function I_can_use_template_with_armors_and_helms(): void
    {
        $controller = $this->mockery(Controller::class);
        $controller->shouldReceive('isAddingNewBodyArmor')
            ->andReturn(false);
        $controller->shouldReceive('isAddingNewHelm')
            ->andReturn(false);
        $controller->shouldReceive('getCurrentValues')
            ->andReturn($currentValues = $this->mockery(CurrentAttackValues::class));
        $currentValues->shouldReceive('getCustomBodyArmorsValues')
            ->andReturn([]);
        $currentValues->shouldReceive('getCustomHelmsValues')
            ->andReturn([]);
        $controller->shouldReceive('getCurrentUrlWithQuery')
            ->zeroOrMoreTimes()
            ->with([Controller::ACTION => Controller::ADD_NEW_HELM])
            ->andReturn('');
        $controller->shouldReceive('getCurrentUrlWithQuery')
            ->zeroOrMoreTimes()
            ->with([Controller::ACTION => Controller::ADD_NEW_BODY_ARMOR])
            ->andReturn('');
        $controller->shouldReceive('getBodyArmors')
            ->andReturn([]);
        $controller->shouldReceive('getMessagesAboutArmors')
            ->andReturn([]);
        $controller->shouldReceive('getHelms')
            ->andReturn([]);
        $controller->shouldReceive('getMessagesAboutHelms')
            ->andReturn([]);
        \ob_start();
        include __DIR__ . '/../../../parts/armor_and_helm.php';
        $content = \ob_get_clean();
        self::assertNotEmpty($content);
    }

    /**
     * @test
     */
    public function I_can_use_template_with_body_properties(): void
    {
        $controller = $this->mockery(Controller::class);
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
        include __DIR__ . '/../../../parts/body_properties.php';
        $content = \ob_get_clean();
        self::assertNotEmpty($content);
    }

    /**
     * @test
     */
    public function I_can_use_template_with_melee_weapons(): void
    {
        $controller = $this->mockery(Controller::class);
        $controller->shouldReceive('isAddingNewMeleeWeapon')
            ->andReturn(false);
        $controller->shouldReceive('getAttack')
            ->andReturn($attack = $this->mockery(AttackForCalculator::class));
        $attack->shouldReceive('getCurrentMeleeWeapon')
            ->andReturn(MeleeWeaponCode::getIt(MeleeWeaponCode::HAND));
        $controller->shouldReceive('getCurrentValues')
            ->andReturn($currentValues = $this->mockery(CurrentAttackValues::class));
        $currentValues->shouldReceive('getCustomMeleeWeaponsValues')
            ->andReturn([]);
        $controller->shouldReceive('getCurrentUrlWithQuery')
            ->zeroOrMoreTimes()
            ->with([Controller::ACTION => Controller::ADD_NEW_MELEE_WEAPON])
            ->andReturn('');
        $controller->shouldReceive('getMeleeWeapons')
            ->andReturn([]);
        $attack->shouldReceive('getCurrentMeleeWeaponHolding')
            ->andReturn(ItemHoldingCode::getIt(ItemHoldingCode::MAIN_HAND));
        $controller->shouldReceive('getMessagesAboutMelee')
            ->andReturn([]);
        \ob_start();
        include __DIR__ . '/../../../parts/melee_weapon.php';
        $content = \ob_get_clean();
        self::assertNotEmpty($content);
    }

    /**
     * @test
     */
    public function I_can_use_template_with_ranged_weapons(): void
    {
        $controller = $this->mockery(Controller::class);
        $controller->shouldReceive('isAddingNewRangedWeapon')
            ->andReturn(false);
        $controller->shouldReceive('getAttack')
            ->andReturn($attack = $this->mockery(AttackForCalculator::class));
        $attack->shouldReceive('getCurrentRangedWeapon')
            ->andReturn(RangedWeaponCode::getIt(RangedWeaponCode::SAND));
        $controller->shouldReceive('getCurrentValues')
            ->andReturn($currentValues = $this->mockery(CurrentAttackValues::class));
        $currentValues->shouldReceive('getCustomRangedWeaponsValues')
            ->andReturn([]);
        $controller->shouldReceive('getCurrentUrlWithQuery')
            ->zeroOrMoreTimes()
            ->with([Controller::ACTION => Controller::ADD_NEW_RANGED_WEAPON])
            ->andReturn('');
        $controller->shouldReceive('getRangedWeapons')
            ->andReturn([]);
        $attack->shouldReceive('getCurrentRangedWeaponHolding')
            ->andReturn(ItemHoldingCode::getIt(ItemHoldingCode::MAIN_HAND));
        $controller->shouldReceive('getMessagesAboutRanged')
            ->andReturn([]);
        \ob_start();
        include __DIR__ . '/../../../parts/ranged_weapon.php';
        $content = \ob_get_clean();
        self::assertNotEmpty($content);
    }

    /**
     * @test
     */
    public function I_can_use_template_with_shields(): void
    {
        $controller = $this->mockery(Controller::class);
        $controller->shouldReceive('isAddingNewShield')
            ->andReturn(false);
        $controller->shouldReceive('getAttack')
            ->andReturn($attack = $this->mockery(AttackForCalculator::class));
        $attack->shouldReceive('getCurrentShield')
            ->andReturn(ShieldCode::getIt(ShieldCode::WITHOUT_SHIELD));
        $controller->shouldReceive('getCurrentValues')
            ->andReturn($currentValues = $this->mockery(CurrentAttackValues::class));
        $currentValues->shouldReceive('getCustomShieldValues')
            ->andReturn([]);
        $controller->shouldReceive('getCurrentUrlWithQuery')
            ->zeroOrMoreTimes()
            ->with([Controller::ACTION => Controller::ADD_NEW_SHIELD])
            ->andReturn('');
        $controller->shouldReceive('getShields')
            ->andReturn([]);
        $attack->shouldReceive('getCurrentShieldWeaponHolding')
            ->andReturn(ItemHoldingCode::getIt(ItemHoldingCode::MAIN_HAND));
        $controller->shouldReceive('getMessagesAboutShield')
            ->andReturn([]);
        \ob_start();
        include __DIR__ . '/../../../parts/shield.php';
        $content = \ob_get_clean();
        self::assertNotEmpty($content);
    }
}