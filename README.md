Yii-User Installation
=====================

Download
--------

Download or checkout (SVN/Git) from http://yii-user.2mx.org and unpack files in your protected/modules/user

Git clone
---------

    clone git git@github.com:garyburge/yii-user.git

Configure
---------

Change your config main:

  // Define a path alias for the Yii-User module to make integration simple
  // Be sure to change the path if you did not unzip or clone into the "modules" folder

  Yii::setPathOfAlias('user', dirname(__FILE__) . '/../modules/user');

  // add to "modules" and "components...
  return array(

    'modules'=>array(
      #...
      'user'=>array(
        // add properties (default values shown)
        # encrypting method (php hash function)
        'hash' => 'sha1',

        # send activation email
        'sendActivationMail' => true,

        # allow access for non-activated users
        'loginNotActiv' => false,

        # activate user on registration (only sendActivationMail = false)
        'activeAfterRegister' => false,

        # automatically login from registration
        'autoLogin' => true,

        # registration path
        'registrationUrl' => array('/user/registration'),

        # recovery password path
        'recoveryUrl' => array('/user/recovery'),

        # login form path
        'loginUrl' => array('/user/login'),

        # page after login
        'returnUrl' => array('/user/profile'),

        # page after logout
        'returnLogoutUrl' => array('/user/login'),
      ),
      #...
    ),

    // application components
    'components'=>array(
      #...
      'db'=>array(
        #...
        'tablePrefix' => 'tbl_',
        #...
      ),
      // add user definition, including the WebUser class which extends
      // Yii's CWebUser class
      #...
      'user'=>array(
        // enable cookie-based authentication
        'class' => 'WebUser',
        'allowAutoLogin'=>true,
        'loginUrl' => '/user/login',
        'returnUrl' => '/user/profile', // redirect here after successful login
      ),
      // add authManager using Yii's CDbAuthManager class
      #...
      'authManager'=>array(
        'class'=>'CDbAuthManager',
        'connectionID'=>'db',
      ),
      #...
      // add date format specifications (required for user maintenance views)
      // see http://php.net/manual/en/function.date.php for date() format string definitions
      'format' => array(
        'dateFormat' => 'n/j/y',
        'datetimeFormat' => 'n/j/y g:ia',
      ),
      #...
    ),

  );

Change your config console (required to execute migrations):

  return array(

    'modules'=>array(
      #...
      'user'=>array(
        # encrypting method (php hash function)
        'hash' => 'sha1',

        # send activation email
        'sendActivationMail' => true,

        # allow access for non-activated users
        'loginNotActiv' => false,

        # activate user on registration (only sendActivationMail = false)
        'activeAfterRegister' => false,

        # automatically login from registration
        'autoLogin' => true,

        # registration path
        'registrationUrl' => array('/user/registration'),

        # recovery password path
        'recoveryUrl' => array('/user/recovery'),

        # login form path
        'loginUrl' => array('/user/login'),

        # page after login
        'returnUrl' => array('/user/profile'),

        # page after logout
        'returnLogoutUrl' => array('/user/login'),
      ),
      #...
    ),

  );

Install
-------

Run command (from application/protected):
    yiic migrate --migrationPath=user.migrations

Input admin login, email and password
