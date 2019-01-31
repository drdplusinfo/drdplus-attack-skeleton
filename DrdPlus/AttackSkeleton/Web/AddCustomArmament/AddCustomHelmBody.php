<?php
declare(strict_types=1);

namespace DrdPlus\AttackSkeleton\Web\AddCustomArmament;

use DrdPlus\AttackSkeleton\CurrentArmamentsValues;
use DrdPlus\AttackSkeleton\FrontendHelper;
use Granam\Strict\Object\StrictObject;
use Granam\WebContentBuilder\Web\BodyInterface;

class AddCustomHelmBody extends StrictObject implements BodyInterface
{
    use CancelActionButtonTrait;

    /** @var FrontendHelper */
    private $frontendHelper;

    public function __construct(FrontendHelper $frontendHelper)
    {
        $this->frontendHelper = $frontendHelper;
    }

    public function __toString()
    {
        return $this->getValue();
    }

    public function getValue(): string
    {
        return <<<HTML
<div class="col">
  <label>Název
    <input type="text" placeholder="Název nové helmy" name="{$this->getCustomHelmName()}[0]" required>
  </label>
  <label>Potřebná síla
    <input type="number" min="-20" max="50" value="0" name="{$this->getCustomHelmRequiredStrengthName()}[0]" required>
  </label>
  <label>Omezení
    <input type="number" min="-10" max="20" value="0" name="{$this->getCustomHelmRestrictionName()}[0]" required>
  </label>
  <label>Ochrana
    <input type="number" min="-10" max="20" value="1" name="{$this->getCustomHelmProtectionName()}[0]" required>
  </label>
  <label>Váha v kg
    <input type="number" min="0" max="99.99" value="0.5" name="{$this->getCustomHelmWeightName()}[0]" required>
  </label>
  <input type="submit" class="manual" value="Přidat helmu">
</div>
{$this->getCancelActionButton($this->frontendHelper)}
HTML;
    }

    private function getCustomHelmName(): string
    {
        return CurrentArmamentsValues::CUSTOM_HELM_NAME;
    }

    private function getCustomHelmRequiredStrengthName(): string
    {
        return CurrentArmamentsValues::CUSTOM_HELM_REQUIRED_STRENGTH;
    }

    private function getCustomHelmRestrictionName(): string
    {
        return CurrentArmamentsValues::CUSTOM_HELM_RESTRICTION;
    }

    private function getCustomHelmProtectionName(): string
    {
        return CurrentArmamentsValues::CUSTOM_HELM_PROTECTION;
    }

    private function getCustomHelmWeightName(): string
    {
        return CurrentArmamentsValues::CUSTOM_HELM_WEIGHT;
    }

}