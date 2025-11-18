<?php

use App\Rules\MembershipNumberValidate;

beforeEach(function () {
    $this->rule = new MembershipNumberValidate();
});

it('validates correct membership numbers', function () {
    $validNumbers = [
        '1147-2239-49',
        '0012-3456-72',
        '9876-5432-32',
        '1111-1111-52',
        '2222-2222-07',
        '5555-5555-66',
        '1234-5678-03',
    ];

    foreach ($validNumbers as $number) {
        $failed = false;
        $this->rule->validate('membership_number', $number, function () use (&$failed) {
            $failed = true;
        });

        expect($failed)->toBeFalse("Number {$number} should be valid");
    }
});

it('rejects incorrect checksum', function () {
    $invalidNumbers = [
        '1147-2239-50',
        '1234-5678-43',
        '0000-0097-01',
        '9999-9999-97',
    ];

    foreach ($invalidNumbers as $number) {
        $failed = false;
        $this->rule->validate('membership_number', $number, function () use (&$failed) {
            $failed = true;
        });

        expect($failed)->toBeTrue("Number {$number} should be invalid");
    }
});

it('allows null or empty values', function () {
    $emptyValues = [null, ''];

    foreach ($emptyValues as $value) {
        $failed = false;
        $this->rule->validate('membership_number', $value, function () use (&$failed) {
            $failed = true;
        });

        expect($failed)->toBeFalse("Empty value should be allowed");
    }
});

