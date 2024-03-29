<?php

/**
 * @file classes/user/form/ContactForm.inc.php
 *
 * Copyright (c) 2014-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ContactForm
 * @ingroup user_form
 *
 * @brief Form to edit user's contact information.
 */

import('lib.pkp.classes.user.form.BaseProfileForm');

class ContactForm extends BaseProfileForm {

	/**
	 * Constructor.
	 * @param $user User
	 */
	function __construct($user) {
		parent::__construct('user/contactForm.tpl', $user);

		// Validation checks for this form
		$this->addCheck(new FormValidator($this, 'phone', 'required', 'user.profile.form.phoneRequired')); /* script yang ditambahkan */
		$this->addCheck(new FormValidatorEmail($this, 'email', 'required', 'user.profile.form.emailRequired'));
		$this->addCheck(new FormValidator($this, 'country', 'required', 'user.profile.form.countryRequired'));
		$this->addCheck(new FormValidatorCustom($this, 'email', 'required', 'user.register.form.emailExists', array(DAORegistry::getDAO('UserDAO'), 'userExistsByEmail'), array($user->getId(), true), true));
	}

	/**
	 * @copydoc BaseProfileForm::fetch
	 */
	function fetch($request, $template = null, $display = false) {
		$templateMgr = TemplateManager::getManager($request);
		$site = $request->getSite();
		$countryDao = DAORegistry::getDAO('CountryDAO');
		$templateMgr->assign(array(
			'countries' => $countryDao->getCountries(),
			'availableLocales' => $site->getSupportedLocaleNames(),
		));

		return parent::fetch($request, $template, $display);
	}

	/**
	 * @copydoc BaseProfileForm::initData()
	 */
	function initData() {
		$user = $this->getUser();

		$this->_data = array(
			'country' => $user->getCountry(),
			'email' => $user->getEmail(),
			'phone' => $user->getPhone(),
			'signature' => $user->getSignature(null), // Localized
			'mailingAddress' => $user->getMailingAddress(),
			'affiliation' => $user->getAffiliation(null), // Localized
			'userLocales' => $user->getLocales(),
		);
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		parent::readInputData();

		$this->readUserVars(array(
			'country', 'email', 'signature', 'phone', 'mailingAddress', 'affiliation', 'userLocales',
		));

		if ($this->getData('userLocales') == null || !is_array($this->getData('userLocales'))) {
			$this->setData('userLocales', array());
		}

	}

	/**
	 * Save contact settings.
	 */
	function execute() {
		$user = $this->getUser();

		$user->setCountry($this->getData('country'));
		$user->setEmail($this->getData('email'));
		$user->setSignature($this->getData('signature'), null); // Localized
		$user->setPhone($this->getData('phone'));
		$user->setMailingAddress($this->getData('mailingAddress'));
		$user->setAffiliation($this->getData('affiliation'), null); // Localized

		$request = Application::getRequest();
		$site = $request->getSite();
		$availableLocales = $site->getSupportedLocales();
		$locales = array();
		foreach ($this->getData('userLocales') as $locale) {
			if (AppLocale::isLocaleValid($locale) && in_array($locale, $availableLocales)) {
				array_push($locales, $locale);
			}
		}
		$user->setLocales($locales);

		parent::execute();
	}
}

