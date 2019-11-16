<?php

use App\Datasource\Interfaces\RolesDataInterface;
use App\Datasource\Interfaces\UsersDataInterface;
use App\Datasource\RolesData;
use App\Datasource\UsersData;
use App\Domains\Users;
use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase
{
    public function testIfGetSubordinatesWorksWell()
    {
        $user = new Users($this->mockedUserData(), $this->mockedRolesData());
        $expectedData = [
            ['id' => 2, 'name' => 'Emily Employee', 'role' => 4],
            ['id' => 5, 'name' => 'Steve Trainer', 'role' => 5],
        ];

        $this->assertSame($this->sortMultiDimenArrays($expectedData), $this->sortMultiDimenArrays($user->getSubordinates(3)));

        $this->assertEmpty($user->getSubordinates(2));

        $expectedData = [
            ['id' => 2, 'name' => 'Emily Employee', 'role' => 4],
            ['id' => 3, 'name' => 'Sam Supervisor', 'role' => 3],
            ['id' => 4, 'name' => 'Mary Manager', 'role' => 2],
            ['id' => 5, 'name' => 'Steve Trainer', 'role' => 5],
        ];

        $this->assertSame($this->sortMultiDimenArrays($expectedData), $this->sortMultiDimenArrays($user->getSubordinates(1)));
    }

    public function testIfSearchUserByIdWorks()
    {
        $user = new Users($this->mockedUserData(), $this->mockedRolesData());

        $actualData = $this->invokeMethod($user, 'searchUserById', [2]);
        $this->assertSame(['id' => 2, 'name' => 'Emily Employee', 'role' => 4], $actualData);

        $actualData = $this->invokeMethod($user, 'searchUserById', [1]);
        $this->assertSame(['id' => 1, 'name' => 'Adam Admin', 'role' => 1], $actualData);

        $actualData = $this->invokeMethod($user, 'searchUserById', [10]);
        $this->assertEmpty($actualData);
    }

    public function testIfSearchChildrenRoleByRoleIdWorks()
    {
        $user = new Users($this->mockedUserData(), $this->mockedRolesData());
        $actualData = $this->invokeMethod($user, 'searchChildrenRoleByRoleId', [3]);
        $sortExpectedData = [5, 4];
        $this->assertSame(sort($sortExpectedData), sort($actualData));

        $actualData = $this->invokeMethod($user, 'searchChildrenRoleByRoleId', [1]);
        $sortExpectedData = [5, 3, 4, 5];
        $this->assertSame(sort($sortExpectedData), sort($actualData));

        $actualData = $this->invokeMethod($user, 'searchChildrenRoleByRoleId', [4]);
        $this->assertEmpty($actualData);
    }

    public function testIfSearchUserByRoleIdsWorks()
    {
        $user = new Users($this->mockedUserData(), $this->mockedRolesData());
        $actualData = $this->invokeMethod($user, 'searchUserByRoleIds', [[3, 4]]);

        $expectedData = [
            ['id' => 3, 'name' => 'Sam Supervisor', 'role' => 3],
            ['id' => 2, 'name' => 'Emily Employee', 'role' => 4],
        ];

        $this->assertSame($this->sortMultiDimenArrays($expectedData), $this->sortMultiDimenArrays($actualData));

        $actualData = $this->invokeMethod($user, 'searchUserByRoleIds', [[4]]);
        $expectedData = [
            ['id' => 2, 'name' => 'Emily Employee', 'role' => 4],
        ];

        $this->assertSame($this->sortMultiDimenArrays($expectedData), $this->sortMultiDimenArrays($actualData));
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on
     * @param string $methodName Method name to call
     * @param array  $parameters array of parameters to pass into method
     *
     * @return mixed method return
     */
    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Just to make sure our expectation & actual array remains same for compare.
     *
     * @param $array
     *
     * @return mixed
     */
    private function sortMultiDimenArrays($array)
    {
        usort($array, function ($a, $b) {
            return $a > $b;
        });

        return $array;
    }

    /**
     * We could use a separate set of mocked data here
     * I am using same sort of input data to make it look easier.
     *
     * @return array
     */
    private function mockedUserData(): UsersDataInterface
    {
        return new UsersData();
    }

    private function mockedRolesData(): RolesDataInterface
    {
        return new RolesData();
    }
}
