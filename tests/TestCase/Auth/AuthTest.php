<?php
namespace TinyAuth\Test\Auth;

use Cake\TestSuite\TestCase;
use TinyAuth\Auth\Auth;

/**
 */
class AuthTest extends TestCase {

	//public $fixtures = array('core.cake_session');

	public function setUp() {
		parent::setUp();

		//ClassRegistry::init(array('table' => 'cake_sessions', 'class' => 'Session', 'alias' => 'Session'));
	}

	public function tearDown() {
		parent::tearDown();

		//ClassRegistry::flush();
		//CakeSession::delete('Auth');
	}

	/**
	 * AuthTest::testId()
	 *
	 * @return void
	 * @deprecated
	 */
	public function testId() {
		$this->skipIf(true, 'Deprecated');

		$id = Auth::id();
		$this->assertNull($id);

		CakeSession::write('Auth.User.id', 1);
		$id = Auth::id();
		$this->assertEquals(1, $id);
	}

	/**
	 * AuthTest::testHasRole()
	 *
	 * @return void
	 */
	public function testHasRole() {
		$res = Auth::hasRole(1, [2, 3, 6]);
		$this->assertFalse($res);

		$res = Auth::hasRole(3, [2, 3, 6]);
		$this->assertTrue($res);

		$res = Auth::hasRole(3, 1);
		$this->assertFalse($res);

		$res = Auth::hasRole(3, '3');
		$this->assertTrue($res);

		$res = Auth::hasRole(3, '');
		$this->assertFalse($res);
	}

	/**
	 * AuthTest::testHasRoleWithSession()
	 *
	 * @return void
	 */
	public function testHasRoleWithSession() {
		if (!defined('USER_ROLE_KEY')) {
			define('USER_ROLE_KEY', 'Role');
		}
		//CakeSession::write('Auth.User.id', 1);
		$roles = [
			['id' => '1', 'name' => 'User', 'alias' => 'user'],
			['id' => '2', 'name' => 'Moderator', 'alias' => 'moderator'],
			['id' => '3', 'name' => 'Admin', 'alias' => 'admin'],
		];
		//CakeSession::write('Auth.User.' . USER_ROLE_KEY, $roles);

		$res = Auth::hasRole(4, $roles);
		$this->assertFalse($res);

		$res = Auth::hasRole(3, $roles);
		$this->assertTrue($res);
	}

	/**
	 * AuthTest::testHasRoles()
	 *
	 * @return void
	 */
	public function testHasRoles() {
		$res = Auth::hasRoles([1, 3], [2, 3, 6]);
		$this->assertTrue($res);

		$res = Auth::hasRoles([3], [2, 3, 6]);
		$this->assertTrue($res);

		$res = Auth::hasRoles(3, [2, 3, 6]);
		$this->assertTrue($res);

		$res = Auth::hasRoles([], [2, 3, 6]);
		$this->assertFalse($res);

		$res = Auth::hasRoles(null, [2, 3, 6]);
		$this->assertFalse($res);

		$res = Auth::hasRoles([2, 7], [2, 3, 6], false);
		$this->assertFalse($res);

		$res = Auth::hasRoles([2, 6], [2, 3, 6], false);
		$this->assertTrue($res);

		$res = Auth::hasRoles([2, 6], [2, 3, 6]);
		$this->assertTrue($res);

		$res = Auth::hasRoles([9, 11], []);
		$this->assertFalse($res);

		$res = Auth::hasRoles([9, 11], '');
		$this->assertFalse($res);

		$res = Auth::hasRoles([2, 7], [], false);
		$this->assertFalse($res);

		$res = Auth::hasRoles([2, 7], [], false);
		$this->assertFalse($res);
	}

}