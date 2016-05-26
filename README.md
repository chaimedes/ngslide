# ngslide -- an AngularJS slideshow
![ngslide, an AngularJS slideshow](http://i.imgur.com/F9EHHTd.png)
## Intro
ngslide is a small and straightforward slideshow script I created because I didn't like the existing Angular-based slideshows.
There is one main JS file, but it couples with a small PHP script and a MySQL database to provide a more realistic environment
than the slideshows that come with preset image objects.

## Setup
You'll need to do the following:
- Run or import the SQL file to create a database
- Add some content to the table. I'm working on an upload script that should be done soon.
- Create an images directory where the uploaded files will be stored. If you use this in production,
move this directory above the document root.
- Add the info for your database connection content in retrieve_sample.php and rename it to retrieve.php.
I know this sounds like a lot of work for a simple slideshow,
but it should hopefully take less than five minutes if you have some experience in this area,
and in the end you'll have a pretty usable system set up.
