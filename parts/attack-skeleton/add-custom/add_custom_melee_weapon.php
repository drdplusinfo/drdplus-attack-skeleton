<?php
namespace DrdPlus\AttackSkeleton;

use \DrdPlus\Codes\Armaments\WeaponCategoryCode;
use DrdPlus\Codes\Body\PhysicalWoundTypeCode;

/** @var \DrdPlus\AttackSkeleton\AttackController $controller */

?>
<label>Název <input type="text" name="<?= CurrentAttackValues::CUSTOM_MELEE_WEAPON_NAME ?>[0]"
                    required="required"></label>
<label>Kategorie <select name="<?= CurrentAttackValues::CUSTOM_MELEE_WEAPON_CATEGORY ?>[0]"
                         required="required">
        <?php foreach (WeaponCategoryCode::getMeleeWeaponCategoryValues() as $meleeWeaponCategoryValue) {
            $weaponCategory = WeaponCategoryCode::getIt($meleeWeaponCategoryValue); ?>
          <option value="<?= $meleeWeaponCategoryValue ?>"><?= $weaponCategory->translateTo('cs') ?></option>
        <?php } ?>
  </select>
</label>
<label>Potřebná síla <input type="number" min="-20" max="50" value="0"
                            name="<?= CurrentAttackValues::CUSTOM_MELEE_WEAPON_REQUIRED_STRENGTH ?>[0]"
                            required="required"></label>
<label>Délka <input type="number" min="0" max="10" value="1"
                    name="<?= CurrentAttackValues::CUSTOM_MELEE_WEAPON_LENGTH ?>[0]"
                    required="required"></label>
<label>Útočnost <input type="number" min="=-20" max="50" value="0"
                       name="<?= CurrentAttackValues::CUSTOM_MELEE_WEAPON_OFFENSIVENESS ?>[0]"
                       required="required"></label>
<label>Zranění <input type="number" min="=-20" max="50" value="0"
                      name="<?= CurrentAttackValues::CUSTOM_MELEE_WEAPON_WOUNDS ?>[0]"
                      required="required"></label>
<label>Typ <select name="<?= CurrentAttackValues::CUSTOM_MELEE_WEAPON_WOUND_TYPE ?>[0]"
                   required="required">
        <?php foreach (PhysicalWoundTypeCode::getPossibleValues() as $woundTypeValue) {
            $woundType = PhysicalWoundTypeCode::getIt($woundTypeValue); ?>
          <option value="<?= $woundTypeValue ?>"><?= $woundType->translateTo('cs') ?></option>
        <?php } ?>
  </select>
</label>
<label>Kryt <input type="number" min="-10" max="20" value="0"
                   name="<?= CurrentAttackValues::CUSTOM_MELEE_WEAPON_COVER ?>[0]"
                   required="required"></label>
<label>Váha v kg <input type="number" min="0" max="99.99" value="1"
                        name="<?= CurrentAttackValues::CUSTOM_MELEE_WEAPON_WEIGHT ?>[0]"
                        required="required"></label>
<label>Pouze obouruční <input type="checkbox" value="1"
                              name="<?= CurrentAttackValues::CUSTOM_MELEE_WEAPON_TWO_HANDED_ONLY ?>[0]"></label>
<input type="submit" value="Přidat">
<a class="button cancel" id="cancelNewMeleeWeapon"
   href="<?= $controller->getCurrentUrlWithQuery([AttackController::ACTION => '']); ?>">Zrušit</a>
