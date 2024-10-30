=== Comment Gatekeeper ===
Contributors: StuartSequeira
Donate link: http://makesenseofitall.com/tag/comment-gatekeeper/
Tags: comments, spam
Requires at least: 3.0.3
Tested up to: 3.8
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Block spam comments by adding a simple question and answer field to your comment forms.

== Description ==

Block comment spam (up to 98% of it !) by inserting a question and answer field on your comment forms.  No more wasting your time emptying out pages of spam messages just to get to the real comments from real visitors!

You can create your own simple question, like "What is 1 plus 1?" and the commenter must supply an answer on the comment form.  If the commenter can't answer the question correctly, this great little plugin blocks the comment from getting into your website.

Thanks to Andrew Kurtis and his team at Web Hosting Hub for translating this plugin into Spanish! 

With the recently added blocked-spam counter, we collected data on our test site that blocked 798 spam comments and allowed only 14 through - a 98% success rate!

== Installation ==

1. Upload the `comment-gatekeeper` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==

= How do I set the question and answer? =

    Go to the Settings Menu > Discussion
    Scroll to the section “Comment Gatekeeper Settings”
    Enter your question and answer
	Save your settings


== Screenshots ==

1. The Settings > Discussion page where the comment gatekeeper question and answer is set; optional CSS classes can be added
2. The spam-filtering question as it appears on the comment form

== Changelog ==

= 1.1.1 =
Update README.txt with recent spam-blocking data

= 1.1 =
Add successfully blocked spam comment counter
Add uninstall function to remove options on uninstall

= 1.0 =
Add Spanish translation

= 0.9.4 =
Modify english instructions to prepare for translations

= 0.9.3 =
Add gettext functions on two English sentences that were missing it

= 0.9.2 =
Add CSS classes to form field
* Add an admin field for optional css classes
* Adds the optional CSS classes to the form

= 0.9.1 =
Feature testing
* Added user-friendly error messages for empty answer field and for incorrect answer field
* Will also see if there are any other improvement ideas from users
* Intend to roll this out as part of 1.0 after testing

= 0.9 =
* Initial submission to WordPress

== Upgrade Notice ==
= 0.9 =
* Initial submission, no upgrade necessary