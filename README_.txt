/**
 * Manage forms for creating user content
 * 
 * @package form
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 * 
 */
 
The Elgg 1.x form plugin provides a web-based system that allows site 
admins to create forms that they and regular users can use to create
content. So you can allow your users to create, read, recommend, 
comment on, and search for any content that you choose to support, from 
restaurant reviews to classified ads.

The form plugin supports a rich and growing set of form elements, including
select and radio boxes, image uploads and Youtube video embeds, search tags
and calendar gadgets. These elements can optionally be split across multiple
tabbed sections to reduce the visual complexity of your forms.

When used in conjunction with the flexprofile, flexgroupprofile and flexfile
plugins, the form plugin allows you to add some of this functionality to
profile and file upload forms, so that you can manage a rich set of profile
and document data through the web.

Activating the form plugin

The zip file contains all four form, flexprofile, flexgroupprofile and flexfile
plugins.

Extract the form plugin and any other plugins that you want to use into the mod
directory. Activate the form plugin as usual using the Elgg 1.x tool 
administration.. Do not activate the flexprofile or flexgroupprofile plugins
until you have created appropriate forms for them to use.

The form plugin creates a "Manage forms" left submenu link on the Elgg
administration pages.

You can set a User Content toggle (next to the Forms entry on the tools
administration page) to create a "User content" link in the Tools menu
once you have created data or search forms. The User content page lists all
the accessible forms in your system to create an overview area if you want
that.

By default the User content link is turned off. As you can see below, you can
also add links to individual forms in the Tool menu.

Non-admins cannot create their own forms in the current version of the form 
plugin but they can submit content using existing forms, comment on and 
recommend content, and search for content created by themselves, their friends, 
or other site users.

Within the "Manage forms" page, site admins have a number of options.

*Add form*

Allows the admin to create a new form. You can specify when creating the form
whether this is a content, user profile, group profile, or file form.

*List all fields*

Lists all the field definitions this admin has created, across all his/her 
forms. Notice that even though the "Manage forms" page lists all the forms in
the system, each admin has his or her own set of field definitions.

*List orphan fields*

Lists all the field definitions this admin has created that are not part of
any form.

*Manage group profile categories*

This provides a simple form to list your categories.

Most (but not all) forms can also be edited directly through admin-specific
links added to the User content page. These are visible only to admins.

Adding a form

After clicking on "Add new form", you are asked for the following information:

*Form name*

A short string giving the internal name for this form. It can be any
combination of letters, numbers and underscores. It should not include
spaces. Each form created by a given admin must have a unique name.

*Title*

The public name for the form. This is displayed at the top of the
form.

*Description*

This is typically used to explain the form for users submitting the form
to provide content. It is displayed below the title. It can contain HTML.

*Form type*

Whether this is a content, user profile, group profile, or file form.

*Access*

You are probably going to want to keep the access "private" at this stage until
you have finished your form.

Once you have created your form, you can edit it and set several more options.
The response text and listing and display templates all default to something 
reasonable if you do not supply values, so you will not need to change these
until or if you want to customise them.

For content forms, these are:

*Response text*

The text that is displayed to thank the user for submitting the form content.
It can contain HTML.

*Listing description*

If you like you can add a paragraph here that describes the form on content
listing pages and on the User content overview page if you have that activated.

*Email form*

Tick this box if the information submitted using this form should be emailed
to someone rather than saved to the database. Note that means that this 
information will not be searchable, cannot be recommended or commented on, and 
should not contain image uploads.

*Email to*

Enter the email address to use if the information submitted using this form
should be emailed to someone rather than saved to the database.

*Allow commenting*

Tick this box if users are allowed to comment on content created using this
form.

*Allow recommending*

Tick this box if users are allowed to recommend content created using this
form.

*Templates*

The list and display templates are required for content forms and optionally
can be used for file forms as well. They are explained in the Form templates
section below.

Adding fields to a form

Once you have created a form, you must add fields to it if it is to be useful.
When you create a form, you are automatically sent to a page that allows you
to edit the form. You can also get to this page by clicking on an edit link
for this form on the form management or user content pages.

When editing a form, you can do additional form configuration as well as add,
change or delete field definitions.

Your field definitions exist independently from your forms once they have been
created and can be added to several of your forms.

There are three places to add fields on the form edit page.

*Add new field*

Enter a new field name here to create a new field definition and add it to this
form. Like form names, a field name should be a combination of letters, numbers
and underscores. It should not include spaces. Each field created by a given 
admin must have a unique name.

*Add existing field*

Enter an existing field name to add this field to the form.

*Copy existing field*

Enter an existing field name to add a copy of this field definition to the
form. You need to rename the field definition and can edit it before adding
it to your form.

Managing field definitions

In addition to the field name, you can define several other pieces of
information when creating a field definition. These are:

*Title*

Displayed before the field input area.

*Description*

Displayed after the field input area to explain what content to enter.

*Default value*

Usually left blank, but can be useful for pulldown or radio buttons.

*Required*

Users must enter something in this field before they submit this form.

*Admin only*

Only admins can view or edit this field. This can be useful if admins want
to add priority information that determines where this content is displayed
in search results. See below for creating content searches.

*Tab*

If the fields added to this form appear in two or more tabs, a tab display is
created that divides this form into several sections.

*Field type*

There are numerous options here.

Some comments on some field types:

The calendar type uses the pop-up calendar that already comes with Elgg 1.x.
I may replace this in future with the jQuery date picker.

The image upload automatically places the uploaded image in the user's file
upload area where it can be viewed separately from the specific form content.

Image upload fields will *not* work unless Elgg's file plugin is activated.

The video box accepts Youtube URLs.

The group category type creates a select (dropdown/pulldown) box to allow users
to specify a group profile category. Currently this will only set a group
profile category if this field is called "group_profile_category".

The invitation box allows the user to send a link to his or her content to
his friends or colleagues. Note that the invitation box does not work properly
if you have the TinyMCE plugin enabled.

The access pulldown allows the user to determine who gets to see this content.

Selecting the contact type allows you to select a number of contact types.
Currently only "url" and "email" have any special functionality. The other
 contact types are currently implemented as text fields.

Selecting the choice type shows an additional set of form elements to add 
field choices. Click on "Add option" to add a field option. Typically
a pulldown or radio chocie type will have several options.

Each option has a value and possibly a label. If the label is not provided,
the value will be used as the label.

After creating your field definition, click on "Add field" or "Change field"
to save it.

Managing your fields

When editing your form definition, you can edit any field attached to that
form in the "Current fields" section.

You can also remove the field or change the field display order by moving
the field up, down, to the top, or to the bottom.

Removing a field from a form does not delete the field definition. There is a
separate place to do that.

Adding your forms to the Tools menu

There are two options to add the content creation or the content display
pages for each form to the Tools menu so that users can easily access your 
forms and the content created using them.

Form templates

When editing your form, you can also specify how the form will appear in
search results (list template) and how it will appear when people view the form
content (display template). The form plugin supplies default templates if
you do not enter anything in these fields.

A current exception is file forms. You need to explicitly provide templates
for this content in order to display it in file listings or when viewing the
file. See the flexfile README.txt for more information.

In both cases, you describe this using a simple through-the-web templating
language.

Templates are required in order to view submissions from content forms. They
can optionally be used to show any special fields that you add to file upload
forms. See the flexfile README.txt for more information about file forms.

In order to display a field value, simply use

{$my_field_name}

in the template.

For image uploads or the video box,

{$my_field_name}

will display the image or video clip player.

You can also use:

{$my_field_name:thumb}

to display a thumbnail for the image or video.

For image upload fields, you can further qualify the thumbnail to get
three standard sizes:

{$my_field_name:thumb:tiny} (60x60)
{$my_field_name:thumb:small} (153x153)
{$my_field_name:thumb:large} (600x600)

There are a number of special variables:

$_url is the site url.

$_full_view_link generates a link to the full content.

$_full_view_url returns the URL to the full content.

$_guid returns the guid of the content.

$_friendlytime returns the creation time of the content in a human readable
format.

$_annotations displays the bits about comments and recommendations if these
are activated for your form. The list version is just a a line that shows the
number of comments and recommendations. The display version provides the link
and form for creating them and shows any existing comments.

There are also a number of variables to display information related to the
owner (the person who made this content submission).

$_owner_message_link allows you to send a message to the user who owns the content.

$_owner_url is the URL for the owner's profile.
$_owner_name is the full name of the owner
$_owner_username is the username of the owner
$_owner_icon is an img tag for the small icon of the owner

Here is a full example for classified ads:

List template

<h2>{$classified_ad_title}</h2>
<p>{$classified_ad_image:thumb}</p>
<p>{$classified_ad_short_description}</p>
<p>{$_full_view_link}<br />
{$_user_message_link}</p>

Display template

<h2>{$classified_ad_title}</h2>
<p>{$classified_ad_image}</p>
<p>{$classified_ad_full_description}</p>
<p>{$_user_message_link}</p>

Search definitions

When editing a form, you can add a search definition. This gives you a way to
specify one or more sophisticated search forms for content created by this
form.

Search definitions are optional. The user content and search pages provide
links to allow users to find content created by themselves and their friends,
as well as all content sorted in chronological order and (if recommendations 
are allowed for that form) in order of recommendations.

Search definitions allow you to create elaborate search forms and to specify
the order in which search results appear. You can also place a search form in
the Tools menu by providing some text in the Menu field.

If a search definition is defined, it is displayed in the user content area
for your form. You can create multiple search definitions for each form.

Form translation

By default, the text for your form will be taken from the form and field
definitions that you saved to the database.

This may not be convenient if you want to translate the form into multiple
languages.

The form translation page lets you export the text from your form and field
definitions into Elgg language files saved in the mod/form/languages/formtrans
directory.

In this way you can create the form text through the web, test the form until
you are satisfied with it, then export the text and produce multiple language
versions.

Managing field definitions

As mentioned above, once created, field definitions are separate from form
definitions. There are two pages that allow you to manage your field
definitions. You can access these pages from links that appear on the left of 
the Manage forms or User content pages.

*List all fields*

This lets you edit any field definition or delete one
entirely and remove it from all your forms.

*List orphan fields*

This lets you edit any orphan field definitions or delete one. An orphan field
is a field that is not currently on any form.

You can also delete all orphan field definitions with one click if you are
viewing this page.



