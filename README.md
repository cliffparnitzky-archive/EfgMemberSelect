Contao EfgMemberSelect Extension
================================

Widget for form generator to select members.


Installation
------------

The extension can be installed using the Contao extension manager in the Contao
back end. If you prefer to install it manually, download the files here:

http://www.contao.org/en/extension-list/view/EfgMemberSelect.html


Tracker
-------

https://github.com/cliffparnitzky/EfgMemberSelect/issues

Insert tags
-----------

Provides all known insert tags to get information of a member as listed [here](http://contao.org/en/insert-tags.html#user-properties) (replace `user` with `formmember::<FORM-FIELD-NAME>` !) .

**Important note:**
The members id will be read from `$_POST` (form method has to be `post`) via `<FORM-FIELD-NAME>`. There will be a solution to use `$_GET` soon.

### Known insert tags are:

~~~~
{{formmember::<FORM-FIELD-NAME>::firstname}} ... This tag will be replaced with the first name of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::lastname}} ... This tag will be replaced with the last name of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::company}} ... This tag will be replaced with the company name of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::phone}} ... This tag will be replaced with the phone number of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::mobile}} ... This tag will be replaced with the mobile number of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::fax}} ... This tag will be replaced with the fax number of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::email}} ... This tag will be replaced with the e-mail address of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::website}} ... This tag will be replaced with the web address of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::street}} ... This tag will be replaced with the street name of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::postal}} ... This tag will be replaced with the postal code of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::city}} ... This tag will be replaced with the city of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::country}} ... This tag will be replaced with the country of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::username}} ... This tag will be replaced with the username of the currently logged in user.
~~~~

### Also useful but not documented insert tags are:

~~~~
{{formmember::<FORM-FIELD-NAME>::dateOfBirth}} ... This tag will be replaced with the date of birth of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::gender}} ... This tag will be replaced with the gender of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::state}} ... This tag will be replaced with the state of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::language}} ... This tag will be replaced with the language of the currently logged in user.
~~~~

### Additional insert tags are:

~~~~
{{formmember::<FORM-FIELD-NAME>::age}} ... This tag will be replaced with the age of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::name}} ... This tag will be replaced with the name (combination of firstname and lastname) of the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::salutation}} ... This tag will be replaced with the salutation (`Ms` or `Mr`) for the currently logged in user.
{{formmember::<FORM-FIELD-NAME>::welcoming::formally}} ... This tag will be replaced with a formally welcoming (`Dear Ms` or `Dear Mr`) for the currently logged in user (the short form is also possible: {{formmember::<FORM-FIELD-NAME>::welcoming}}).
{{formmember::<FORM-FIELD-NAME>::welcoming::personally}} ... This tag will be replaced with a personally welcoming (`Dear`) for the currently logged in user.
~~~~

### Additional information

- For properties with regular expression of `date` / `time` / `datim` (defined in eval array of DCA config) a custom dateformat could be set (e.g. `{{formmember::<FORM-FIELD-NAME>::dateOfBirth::d. M Y}}` will be replaced with `14. Nov 1991`). If no custom format was found, the systems default will be used.
- For properties of datatype `array` and existing foreign key (defined in DCA config) the text values will be read from database (e.g. `{{formmember::<FORM-FIELD-NAME>::groups}}` will be replaced with `Piano Students, Violin Students`).
