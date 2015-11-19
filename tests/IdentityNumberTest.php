<?php namespace Olssonm\IdentityNumber\Tests;

use Validator;
use Olssonm\IdentityNumber\IdentityNumber as Pin;

class IdentityNumberTest extends \Orchestra\Testbench\TestCase {

	public function setUp() {
        parent::setUp();
    }

    /**
     * Load the package
     * @return array the packages
     */
    protected function getPackageProviders($app)
    {
        return [
            'Olssonm\IdentityNumber\IdentityNumberServiceProvider'
        ];
    }

	/** @test */
	public function test_standalone_correct_personal_identity_numbers() {
		$this->assertTrue(Pin::isValid('600411-8177'));
        $this->assertTrue(Pin::isValid('19860210-7313'));
        $this->assertTrue(Pin::isValid('8905247188'));
        $this->assertTrue(Pin::isValid('196711202850'));
	}

	/** @test */
	public function test_standalone_incorrect_personal_identity_numbers() {
		$this->assertFalse(Pin::isValid('600412-8177'));
        $this->assertFalse(Pin::isValid('19860211-7313'));
        $this->assertFalse(Pin::isValid('8905257188'));
        $this->assertFalse(Pin::isValid('196711212850'));
		// Obviously false
		$this->assertFalse(Pin::isValid('00000000-0000'));
		$this->assertFalse(Pin::isValid('11111111-1111'));
		$this->assertFalse(Pin::isValid('22222222-2222'));
		$this->assertFalse(Pin::isValid('33333333-3333'));
		$this->assertFalse(Pin::isValid('44444444-4444'));
		$this->assertFalse(Pin::isValid('55555555-5555'));
		$this->assertFalse(Pin::isValid('66666666-6666'));
		$this->assertFalse(Pin::isValid('77777777-7777'));
		$this->assertFalse(Pin::isValid('88888888-8888'));
		$this->assertFalse(Pin::isValid('99999999-9999'));
	}

	/** @test */
    public function test_standalone_gibberish_data()
	{
		$this->assertFalse(Pin::isValid(null));
        $this->assertFalse(Pin::isValid(false));
        $this->assertFalse(Pin::isValid(true));
        $this->assertFalse(Pin::isValid(111000));
        $this->assertFalse(Pin::isValid(191919191919));
        $this->assertFalse(Pin::isValid(19870822));
        $this->assertFalse(Pin::isValid('Firstname Lastname'));
        $this->assertFalse(Pin::isValid('Gibberish'));
	}

	/** @test */
	public function test_correct_personal_identity_numbers()
	{
        $this->assertTrue($this->validate('600411-8177'));
        $this->assertTrue($this->validate('19860210-7313'));
        $this->assertTrue($this->validate('8905247188'));
        $this->assertTrue($this->validate('196711202850'));
	}

    /** @test */
    public function test_incorrect_personal_identity_numbers()
	{
        $this->assertFalse($this->validate('600412-8177'));
        $this->assertFalse($this->validate('19860211-7313'));
        $this->assertFalse($this->validate('8905257188'));
        $this->assertFalse($this->validate('196711212850'));
		// Obviously false
		$this->assertFalse($this->validate('000000000000'));
		$this->assertFalse($this->validate('111111111111'));
		$this->assertFalse($this->validate('222222222222'));
		$this->assertFalse($this->validate('333333333333'));
		$this->assertFalse($this->validate('444444444444'));
		$this->assertFalse($this->validate('555555555555'));
		$this->assertFalse($this->validate('666666666666'));
		$this->assertFalse($this->validate('777777777777'));
		$this->assertFalse($this->validate('888888888888'));
		$this->assertFalse($this->validate('999999999999'));
	}

    /** @test */
    public function test_gibberish_data()
	{
		$this->assertFalse($this->validate(null));
        $this->assertFalse($this->validate(false));
        $this->assertFalse($this->validate(true));
        $this->assertFalse($this->validate(111000));
        $this->assertFalse($this->validate(191919191919));
        $this->assertFalse($this->validate(19870822));
        $this->assertFalse($this->validate('Firstname Lastname'));
        $this->assertFalse($this->validate('Gibberish'));
	}

	public function test_error_message()
	{
		$this->assertEquals('A standard message', $this->validateWithErrorMessage('600412-8177', 'A standard message'));
		$this->assertEquals('validation.personal_identity_number', $this->validateWithErrorMessage('600412-8177', null));
		$this->assertEquals(true, $this->validateWithErrorMessage('600412-8177', true));
		$this->assertEquals(false, $this->validateWithErrorMessage('600412-8177', false));
	}

    /**
     * validate
     * @param  mixed $pin	the personal identity number
     * @return bool         whether the validation passes or not
     */
    private function validate($pin) {
        $data = ['pnr' => $pin];
        $validator = Validator::make($data, [
            'pnr' => 'personal_identity_number|required',
        ]);

        return $validator->passes();
    }

	/**
     * validate
     * @param  mixed $pin	 the personal identity number
     * @return bool          whether the validation passes or not
     */
    private function validateWithErrorMessage($pin, $message) {
        $data = ['pnr' => $pin];
        $validator = Validator::make($data, [
            'pnr' => 'personal_identity_number',
        ],[
			'pnr.personal_identity_number' => $message
		]);

		$errors = $validator->errors();

        return $errors->first('pnr');
    }
}
