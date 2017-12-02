<div align="center">
	<h1> Simple Social Network </h1>
</div>

<div align="center">
	<a href="#changelog">
		<img src="https://img.shields.io/badge/stability-experimental-orange.svg" alt="Status">
	</a>
	<a href="#changelog">
		<img src="https://img.shields.io/badge/release-v1.0.0--beta.1-yellow.svg" alt="Version">
	</a>
	<a href="#changelog">
		<img src="https://img.shields.io/badge/update-december-yellowgreen.svg" alt="Update">
	</a>
	<a href="#license">
		<img src="https://img.shields.io/badge/license-MIT%20License-green.svg" alt="License">
	</a>
</div>

Fav Quote is a Micro Social Network with PHP, MySQL (PDO), Bootstrap 3 and
 Vue.JS 2. This project don't not use classes or a php framework.

To validate the login forms uses the [validator for bootstrap](http://1000hz.github.io/bootstrap-validator/)

<a name="started"></a>
## :traffic_light: Getting Started

This page will help you get started with Fav Quote (Simple Social Network).

<a name="requirements"></a>
### Requirements

  * PHP 5.6
  * MySQL or MariaDB
  * Apache Server

<a name="installation"></a>
### Installation

#### Create a database

Run the following SQL script

```SQL
-- -----------------------------------------------------
-- Schema NETWORK
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `NETWORK` DEFAULT CHARACTER SET utf8 ;
USE `NETWORK` ;

-- -----------------------------------------------------
-- Table `NETWORK`.`USERS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NETWORK`.`USERS` (
  `ID_USER` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `USERNAME` VARCHAR(20) NOT NULL,
  `PASSWORD` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`ID_USER`),
  UNIQUE INDEX `ID_USER_UNIQUE` (`ID_USER` ASC),
  UNIQUE INDEX `USER_UNIQUE` (`USERNAME` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `NETWORK`.`QUOTES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NETWORK`.`QUOTES` (
  `ID_QUOTE` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `QUOTE` VARCHAR(120) NOT NULL,
  `POST_DATE` DATETIME NOT NULL DEFAULT NOW(),
  `LIKES` INT UNSIGNED NOT NULL DEFAULT 0,
  `ID_USER` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`ID_QUOTE`),
  UNIQUE INDEX `ID_QUOTE_UNIQUE` (`ID_QUOTE` ASC),
  INDEX `fk_QUOTES_USERS_idx` (`ID_USER` ASC),
  CONSTRAINT `fk_QUOTES_USERS`
    FOREIGN KEY (`ID_USER`)
    REFERENCES `NETWORK`.`USERS` (`ID_USER`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
```

#### Create a project

  1. Clone or Download this repository
  2. Unzip the archive if needed
  3. Copy the folder in the htdocs dir
  4. Start a Text Editor (Atom, Sublime, Visual Studio Code, Vim, etc)
  5. Add the project folder to the editor

<a name="built"></a>
## :wrench: Built With

  * XAMPP ([XAMPP for Windows 5.6.32](https://www.apachefriends.org/download.html))
  * ATOM ([ATOM](https://atom.io/))

<a name="test"></a>
## :100: Running the tests

You can test a [demo websites](https://fav-quote.000webhostapp.com/).

<a name="changelog"></a>
## :information_source: Changelog

**1.0.0.1** (02/12/2017)

  * <table border="0" cellpadding="4">
		<tr>
			<td>
				<strong>Language:</strong>
			</td>
			<td>
				HTML, PHP, JavaScript
			</td>
		</tr>
		<tr>
			<td><strong>
				Requirements:
			</strong></td>
			<td>
				<ul>
					<li>
						PHP 5.6
					</li>
					<li>
						My SQL or MariaDB 
					</li>
					<li>
						Apache Server
					</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td><strong>
				Features:
			</strong></td>
			<td>
				<ul>
					<li>
						Bootstrap 3
					</li>
					<li>
						Validator for Bootstrap 3 
					</li>
					<li>
						Vue.JS 2
					</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<strong>Changes:</strong>
			</td>
			<td>
				<ul>
					<li>
						Add validator for Bootstrap
					</li>
					<li>
						Add terms of service
					</li>
				</ul>
			</td>
		</tr>
	</table>

<a name="Donate"></a>
## :gift: Donate!

If you want to help me to continue this project, you might donate via PayPal.

<a href="https://paypal.me/ManuelFGil"><img src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_donate_92x26.png" alt="Donate via PayPal"></a>

<a name="authors"></a>
## :eyeglasses: Authors

  * **Manuel Gil** - *Initial work* - [ManuelGil](https://github.com/ManuelGil) 

See also the list of [contributors](https://github.com/ManuelGil/Simple-Social-Network/contributors)
 who participated in this project.

<a name="license"></a>
## :memo: License

Fav Quote is licensed under the MIT License - see the
 [MIT License](https://opensource.org/licenses/MIT) for details.
