<?php namespace Olssonm\IdentityNumber;

use Validator;

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
	public function test_correct_personal_identity_numbers()
	{
        $this->assertTrue($this->validate('600411-8177'));
        $this->assertTrue($this->validate('19860210-7313'));
        $this->assertTrue($this->validate('8905247188'));
        $this->assertTrue($this->validate('196711202850'));
	}

    /** @test */
    public function test_incorrect_peronal_identity_numbers()
	{
        $this->assertFalse($this->validate('600412-8177'));
        $this->assertFalse($this->validate('19860211-7313'));
        $this->assertFalse($this->validate('8905257188'));
        $this->assertFalse($this->validate('196711212850'));
	}

    /** @test */
    public function test_gibberish_data()
	{
        $this->assertFalse($this->validate(false));
        $this->assertFalse($this->validate(true));
        $this->assertFalse($this->validate(111000));
        $this->assertFalse($this->validate(191919191919));
        $this->assertFalse($this->validate(19870822));
        $this->assertFalse($this->validate('Firstname Lastname'));
        $this->assertFalse($this->validate('Gibberish'));
	}

    /**
     * validate
     * @param  mixed $number the personal identity number
     * @return bool          whether the validation passes or not
     */
    private function validate($number) {
        $data = ['pnr' => $number];
        $validator = Validator::make($data, [
            'pnr' => 'personal_identity_number',
        ]);

        return $validator->passes();
    }
}
