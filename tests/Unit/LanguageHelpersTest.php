<?php

test('identify a signed language', function () {
    expect(is_signed_language('ase'))->toBeTrue();
    expect(is_signed_language('en'))->toBeFalse();
});

test('get available languages', function () {
    $languages = get_available_languages();

    expect($languages)->toHaveCount(4)->toHaveKey('ase');
    expect(array_values($languages)['0'])->toEqual('English');
    expect(array_values($languages)['3'])->toEqual('Quebec Sign Language');
});

test('get all available languages', function () {
    $languages = get_available_languages(true);

    expect(array_shift($languages))->toEqual('English');
    expect(array_shift($languages))->toEqual('French');

    expect($languages)->toHaveKey('es');
    expect(isset($languages['en_CA']))->toBeFalse();
    expect(isset($languages['fr_CA']))->toBeFalse();
});

test('get a signed language exonym', function () {
    expect(get_language_exonym('ase', 'en'))->toEqual('American Sign Language');
});

test('get a written or spoken language exonym', function () {
    expect(get_language_exonym('fr', 'fr', false))->toEqual('français');
});

test('get a capitalized written or spoken language exonym', function () {
    expect(get_language_exonym('fr', 'fr'))->toEqual('Français');
});

test('get an invalid language exonym', function () {
    expect(get_language_exonym('xyz'))->toBeNull();
});
