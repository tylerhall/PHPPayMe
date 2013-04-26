PHPPayMe
======================

I needed a simple way for clients, friends, and family members to send me payments. This is my solution. It's a simple,
one-page PHP script that lets people choose an amount and make a secure credit/debit card payment via
[Stripe](http://stripe.com).

A few weeks ago there was a Hacker News discussion about a ready-made Rails solution you could deploy to Heroku to do
the same thing. I thought folks might appreciate a (simpler) PHP solution, so I open sourced my little bit of code.
Hope you find it useful.

Here's a demo: [http://pay.clickontyler.com](http://clickontyler.com)

## Setup

1. Upload the files to your website.
2. Rename `config.inc.sample.php` to `config.inc.php`
3. Fill in the public and private keys in `config.inc.php` with your own Stripe API keys.
4. Change the HTML text to say your name instead of mine.
