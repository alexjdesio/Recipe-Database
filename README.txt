Implementation of a recipe database using PHP + SQL

Requirements:
-mysqli enabled in your php.ini file

Video of v0.1.3: https://www.youtube.com/watch?v=R39md8vP9t4
Picture of view.php in v0.1.4: https://imgur.com/a/4JC1igW
Video of v0.1.5: https://www.youtube.com/watch?v=ULKBn_U74i0


v0.1.5
- Prevented submission of multiple recipes with the same name
- Recipes are no longer submitted if the image upload encounters an error
- Added edit.php, recipes can now be edited and updated repeatedly

Planned features for v0.1.6:
- Stored images will be deleted when a recipe is deleted
- Stored images will be deleted when they are replaced by another image
- Images will have more thorough MIME type checking and other error checking
