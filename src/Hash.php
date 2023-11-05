<?php

namespace OpenSubtitles;

/**
 * @source https://trac.opensubtitles.org/projects/opensubtitles/wiki/HashSourceCodes#PHP45
 */
class Hash
{
    public function make($file): string
    {
        $handle = fopen($file, "rb");
        $fsize = filesize($file);

        $hash = [
            3 => 0,
            2 => 0,
            1 => ($fsize >> 16) & 0xFFFF,
            0 => $fsize & 0xFFFF
        ];

        for ($i = 0; $i < 8192; $i++) {
            $tmp = $this->readUnsignedInteger64($handle);
            $hash = $this->addUnsignedInteger64($hash, $tmp);
        }

        $offset = $fsize - 65536;
        fseek($handle, max($offset, 0));

        for ($i = 0; $i < 8192; $i++) {
            $tmp = $this->readUnsignedInteger64($handle);
            $hash = $this->addUnsignedInteger64($hash, $tmp);
        }

        fclose($handle);
        return $this->unsignedInteger64FormatHex($hash);
    }

    private function readUnsignedInteger64($handle): array
    {
        $u = unpack('va/vb/vc/vd', fread($handle, 8));
        return [
            $u['a'],
            $u['b'],
            $u['c'],
            $u['d']
        ];
    }

    private function addUnsignedInteger64($a, $b): array
    {
        $o = [0, 0, 0, 0];

        $carry = 0;
        for ($i = 0; $i < 4; $i++) {
            if (($a[$i] + $b[$i] + $carry) > 0xffff) {
                $o[$i] += ($a[$i] + $b[$i] + $carry) & 0xffff;
                $carry = 1;
            } else {
                $o[$i] += ($a[$i] + $b[$i] + $carry);
                $carry = 0;
            }
        }

        return $o;
    }

    private function unsignedInteger64FormatHex($n): string
    {
        return sprintf("%04x%04x%04x%04x", $n[3], $n[2], $n[1], $n[0]);
    }
}
