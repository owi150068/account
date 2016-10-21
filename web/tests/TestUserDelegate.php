<?php 
    require_once __DIR__.'/../delegates/auth_delegate.php';
    require_once __DIR__.'/../delegates/user_delegate.php';

    class UserDelegateTest extends PHPUnit_Framework_TestCase{
        public function setUp(){
                parent::setUp();
        }
        public function tearDown(){
            parent::tearDown();
        }
        public function testUpdateUserName(){
            //test goes here
           update_user_name(1, 'Test');
            $databaseUser = get_user_by_email('mark@facebook.com');
            
            $this->assertEquals('Test', $databaseUser['name']);
            
            //undo side effect
            update_user_name(1, "Mark");
        }
        
        public function testUpdateUserEmail(){
            update_user_email(1, 'test@here.com');
            $databaseUser = get_user_by_email('test@here.com');
            
            $this->assertEquals('Mark', $databaseUser['name']);
            
            update_user_email(1, 'mark@facebook.com');
        }
    }
?>