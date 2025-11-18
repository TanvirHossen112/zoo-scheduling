<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can schedule visitor with valid membership number', function () {
    $response = $this->postJson('/api/v1/schedule', [
        'date' => now()->addDay()->toDateString(),
        'timeslot' => 10,
        'visitors' => [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'membership_number' => '1147-2239-49',
            ],
        ],
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['message']);
});

it('rejects invalid membership number checksum', function () {
    $response = $this->postJson('/api/v1/schedule', [
        'date' => now()->addDay()->toDateString(),
        'timeslot' => 10,
        'visitors' => [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'membership_number' => '1147-2239-50', // Invalid checksum
            ],
        ],
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['visitors.0.membership_number']);
});

it('rejects invalid membership number format', function () {
    $invalidFormats = [
        '1147223949',      // No hyphens
        '1147-223-949',    // Wrong hyphen positions
        'ABCD-1234-56',    // Letters
        '147-2239-49',     // Too few digits
        '11472-2239-49',   // Too many digits in first part
    ];

    foreach ($invalidFormats as $invalidNumber) {
        $response = $this->postJson('/api/v1/schedule', [
            'date' => now()->addDay()->toDateString(),
            'timeslot' => 10,
            'visitors' => [
                [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'membership_number' => $invalidNumber,
                ],
            ],
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['visitors.0.membership_number']);
    }
});

it('allows nullable membership number', function () {
    $response = $this->postJson('/api/v1/schedule', [
        'date' => now()->addDay()->toDateString(),
        'timeslot' => 10,
        'visitors' => [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'membership_number' => null,
            ],
        ],
    ]);

    $response->assertStatus(201);
});

it('can schedule multiple visitors with valid numbers', function () {
    $response = $this->postJson('/api/v1/schedule', [
        'date' => now()->addDay()->toDateString(),
        'timeslot' => 10,
        'visitors' => [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'membership_number' => '1111-1111-52',
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'membership_number' => '2222-2222-07',
            ],
            [
                'first_name' => 'Bob',
                'last_name' => 'Johnson',
                'membership_number' => '1234-5678-03',
            ],
        ],
    ]);

    $response->assertStatus(201);
});

it('rejects duplicate membership number', function () {
    // First schedule
    $this->postJson('/api/v1/schedule', [
        'date' => now()->addDay()->toDateString(),
        'timeslot' => 10,
        'visitors' => [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'membership_number' => '1147-2239-49',
            ],
        ],
    ]);

    // Try to schedule again with same membership number
    $response = $this->postJson('/api/v1/schedule', [
        'date' => now()->addDays(2)->toDateString(),
        'timeslot' => 12,
        'visitors' => [
            [
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'membership_number' => '1147-2239-49',
            ],
        ],
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['visitors.0.membership_number']);
});

it('validates all required fields', function () {
    $response = $this->postJson('/api/v1/schedule', [
        'visitors' => [
            [
                'membership_number' => '1147-2239-49',
            ],
        ],
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'date',
            'timeslot',
            'visitors.0.first_name',
            'visitors.0.last_name',
        ]);
});
