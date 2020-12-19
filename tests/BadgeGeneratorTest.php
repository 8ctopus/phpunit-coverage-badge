<?php


use PHPUnit\Framework\TestCase;
use PhpUnitCoverageBadge\BadgeGenerator;

class BadgeGeneratorTest extends TestCase
{
    const VALID_BADGE = <<<EOT
<svg width="100" height="20" xmlns="http://www.w3.org/2000/svg">
<!-- Created with Method Draw - http://github.com/duopixel/Method-Draw/ -->

 <g>
  <title>background</title>
  <rect fill="none" id="canvas_background" height="22" width="102" y="-1" x="-1"/>
 </g>
 <g>
  <title>Layer 1</title>
  <rect rx="2" id="svg_1" height="18" width="98" y="1" x="1" stroke-width="1.5" stroke="#4c4c4c" fill="#4c4c4c"/>
  <text transform="matrix(0.95, 0, 0, 1.01133, 0.0809801, -0.0237383)" font-weight="normal" xml:space="preserve" text-anchor="start" font-family="'Trebuchet MS', Gadget, sans-serif" font-size="12" id="svg_8" y="14.45" x="2.8" stroke-width="0" stroke="#4c4c4c" fill="#6e747d">coverage</text>
  <text transform="matrix(0.95, 0, 0, 1.01133, 0.0809801, -0.0237383)" font-weight="normal" xml:space="preserve" text-anchor="start" font-family="'Trebuchet MS', Gadget, sans-serif" font-size="12" id="svg_3" y="13.9" x="2.2" stroke-width="0" stroke="#4c4c4c" fill="#ffffff">coverage</text>
  <rect rx="2" id="svg_5" height="18" width="40.90531" y="1.01077" x="58.13716" stroke-width="1.5" stroke="#e05d44" fill="#e05d44"/>
  <rect id="svg_7" height="18" width="10" y="1.01077" x="58.00804" stroke-width="1.5" stroke="#e05d44" fill="#e05d44"/>
  <text transform="matrix(0.95, 0, 0, 1.01133, 0.0809801, -0.0237383)" font-weight="normal" xml:space="preserve" text-anchor="end" font-family="'Trebuchet MS', Gadget, sans-serif" font-size="10" id="svg_10" y="14.35" x="99" stroke-width="0" stroke="#4c4c4c" fill="#6e747d">11 %</text>
  <text transform="matrix(0.95, 0, 0, 1.01133, 0.0809801, -0.0237383)" font-weight="normal" xml:space="preserve" text-anchor="end" font-family="'Trebuchet MS', Gadget, sans-serif" font-size="10" id="svg_9" y="13.8" x="98.4" stroke-width="0" stroke="#4c4c4c" fill="#ffffff">11 %</text>
 </g>
</svg>
EOT;

    public function testDirectoryDoesNotExistPreviously(): void
    {
        $badgeGenerator = new BadgeGenerator();

        $badgeGenerator->saveBadge(self::VALID_BADGE, 'tests/this/is/no/directory/test_badge.svg');

        $this->assertFileExists(__DIR__ . '/this/is/no/directory/test_badge.svg');

        if (!file_exists(__DIR__ . '/this/is/no/directory/test_badge.svg')) {
            return;
        }

        unlink(__DIR__ . '/this/is/no/directory/test_badge.svg');
        rmdir(__DIR__ . '/this/is/no/directory');
        rmdir(__DIR__ . '/this/is/no');
        rmdir(__DIR__ . '/this/is');
        rmdir(__DIR__ . '/this');
    }

    public function testOverwritingBadge(): void
    {
        $badgeGenerator = new BadgeGenerator();

        $badgeGenerator->saveBadge(self::VALID_BADGE, 'tests/resources/test_badge.svg');

        $badgePath = __DIR__ . '/resources/test_badge.svg';
        if (!file_exists($badgePath)) {
            return;
        }

        $updatedBadgeContent = file_get_contents($badgePath);

        $this->assertEquals(self::VALID_BADGE, $updatedBadgeContent);

        unlink($badgePath);
        copy(dirname($badgePath) . '/test_badge_backup.svg', $badgePath);
    }
}