<?php

namespace Tests\Feature\Helpers;

use Illuminate\Support\Str;
use Tests\TestCase;

class StringMacroTests extends TestCase
{
    public function test_remove_doctor_prefix_macro()
    {
        $string = 'Dr. Teste User';
        $expectedResult = 'Teste User';

        $result = Str::removeDoctorPrefix($string);

        $this->assertEquals($expectedResult, $result);
    }

    public function test_remove_doctor_prefix_macro_with_multiple_prefixes()
    {
        $string = 'Dra. Dr. Teste User';
        $expectedResult = 'Teste User';

        $result = Str::removeDoctorPrefix($string);

        $this->assertEquals($expectedResult, $result);
    }
}
