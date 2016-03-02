<?php
/**
 * User: wei
 * Date: 2016/3/2
 * Time: 上午 12:22
 */

namespace App\Library;

use App\User;
use App\DateApplication;
use Faker\Factory;

class MatchDates
{
	protected $genderArr = ['male','female'];

	// city array
	protected $cityArr = ['台北', '新竹', '我都可以唷'];

    // vegetarian type array
	protected $vegetarianTypeArr = ['是', '否', '我都可以唷'];

    // meal type array
	protected $mealTypeArr = ['西餐', '中餐', '我都可以唷'];

    // sex constraint array
	protected $sexConstriantArr = ['男', '女', '我都可以唷'];

    // time minutes array
	protected $minuteArr = ['30', '00'];

    // time range
	protected $timeArr;

	public function __construct()
	{
		// create time array
		$this->timeArr = range(1700, 2300, 100);

		// push zero into time array
		array_push($this->timeArr, 0,0);

		// shuffle time array to randomize it
		shuffle($this->timeArr);
	}

	public function test()
	{
		var_dump(User::where('id', 1)->first()->email);
	}

	/**
	* generate test date applications and users
	* @param int
	* @return mixed
	*/
	public function generateTestDate($numberOfDate){

		// process time start
		$pStartTime = microtime(true);

		// faker
		$faker = Factory::create();

		// gender random array
		$genderArr = ['male', 'female'];

		for($i = 0; $i < $numberOfDate; $i++){
        	// fake user data
			$fakeUserData = [
			'nickname' => $faker->userName,
			'email' => $faker->email,
			'password' => bcrypt(str_random(10)),
			'real_name' => $faker->firstName,
			'sex' => $this->genderArr[rand(0,1)],
			'year' => $faker->year,
			'month' => $faker->month,
			'date' => $faker->dayOfMonth,
			'phone_number' => $faker->phoneNumber,
			'confirmed' => 1,
			'remember_token' => str_random(10),
			];

			// create faker user
			$fakeUser = User::create($fakeUserData);

			// time range
			$timeRange = array_rand($this->timeArr, 2);

        	// start time
			$startTime = $this->timeArr[$timeRange[1]];

        	// end time
			$endTime = $this->timeArr[$timeRange[0]];

			// swap time range if not reasonable
			if ($startTime > $endTime && $startTime != 0 && $endTime != 0) {
				list($startTime,$endTime) = array($endTime,$startTime);
			}

			// fake date applicatoin
			$fakeDateAppData = [
			'user_id' => $fakeUser->id,
			'city' => $this->cityArr[array_rand($this->cityArr, 1)],
			'start_time' => $startTime,
			'end_time' => $endTime,
			'vegetarian_type' => $this->vegetarianTypeArr[array_rand($this->vegetarianTypeArr, 1)],
			'meal_type' => $this->mealTypeArr[array_rand($this->mealTypeArr, 1)],
			'sex_constraint' => $this->genderArr[array_rand($this->genderArr, 1)]
			];

			// create fake date applicatoin
			$fakeDateApp = DateApplication::create($fakeDateAppData);

		}

		$pTime = microtime(true) - $pStartTime;

		echo 'process time is '.$pTime;
	}

	public function match(){

    	// step 0 get a random user
		if(User::where('id',1)->first()){
			echo 'fucking defined';
		}
		else{
			echo 'fucking not defined';
		}

		while(DateApplication::where('matched',false)->first()){

		}
	}

} 
