{**
 * templates/user/contactForm.tpl
 *
 * Copyright (c) 2014-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * User profile form.
 *}

{* Help Link *}
{help file="user-profile.md" class="pkp_help_tab"}

<script type="text/javascript">
	$(function() {ldelim}
		// Attach the form handler.
		$('#contactForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form class="pkp_form" id="contactForm" method="post" action="{url op="saveContact"}">
	{csrf}

	{include file="controllers/notification/inPlaceNotification.tpl" notificationId="contactFormNotification"}

	{fbvFormSection}
		{fbvElement type="text" label="user.email" id="email" value=$email size=$fbvStyles.size.MEDIUM required=true}
		<br><br> <!-- script yang ditambahkan agar lebih rapi -->
		{fbvElement type="textarea" label="user.signature" multilingual="true" name="signature" id="signature" value=$signature rich=true size=$fbvStyles.size.MEDIUM}
		<br><br> <!-- script yang ditambahkan agar lebih rapi -->
		{fbvElement type="text" label="user.phone" name="phone" id="phone" required=true value=$phone maxlength="24" size=$fbvStyles.size.SMALL} <!-- script required=true yang ditambahkan -->
		<br><br> <!-- script yang ditambahkan agar lebih rapi -->
		{fbvElement type="text" label="user.affiliation" multilingual="true" name="affiliation" id="affiliation" value=$affiliation size=$fbvStyles.size.MEDIUM}
		<br><br> <!-- script yang ditambahkan agar lebih rapi -->
	{/fbvFormSection}
	{fbvFormSection}
		{fbvElement type="textarea" label="common.mailingAddress" name="mailingAddress" id="mailingAddress" rich=true value=$mailingAddress size=$fbvStyles.size.MEDIUM}
		<br><br> <!-- script yang ditambahkan agar lebih rapi -->
		{fbvElement type="select" label="common.country" name="country" id="country" required=true defaultLabel="" defaultValue="" from=$countries selected=$country translate=false size=$fbvStyles.size.MEDIUM}
		<br><br> <!-- script yang ditambahkan agar lebih rapi -->
	{/fbvFormSection}

	{if count($availableLocales) > 1}
		{fbvFormSection title="user.workingLanguages" list=true}
			{foreach from=$availableLocales key=localeKey item=localeName}
				{if $userLocales && in_array($localeKey, $userLocales)}
					{assign var="checked" value=true}
				{else}
					{assign var="checked" value=false}
				{/if}
				{fbvElement type="checkbox" name="userLocales[]" id="userLocales-$localeKey" value=$localeKey checked=$checked label=$localeName translate=false}
			{/foreach}
		{/fbvFormSection}
		<br><br> <!-- script yang ditambahkan agar lebih rapi -->
	{/if}

	{fbvFormButtons hideCancel=true submitText="common.save"}

	<p>
		{capture assign="privacyUrl"}{url router=$smarty.const.ROUTE_PAGE page="about" op="privacy"}{/capture}
		{translate key="user.privacyLink" privacyUrl=$privacyUrl}
	</p>

	<p><span class="formRequired">{translate key="common.requiredField"}</span></p>
</form>
