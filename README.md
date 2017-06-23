# Photogallery-On-PHP

Simple photogallery based on PHP

## General idea behind the Photogallery On PHP

I needed for some of my project web gallery which is automatically generated from directory structure with photos. Therefore I created simle photogallery based on PHP. 

## Supported features

* support for **mobile devices** - photogallery looks nice on mobile devices since for displaying images is used [Photoswipe](http://photoswipe.com/)
* support for **discussions** - one discussion is present in photogallery and each photoalbum in photogallery has again its own discussion
* support for **Google Analytics** - you just enter your script into ```google_analytics.txt``` and subsequently it is generated into all photogallery web pages which user can see

## How it works?

In one private folder (which is not directly exposed to the Internet) you just needs to configure photogallery (enter some information, password, upload photos) and into another folder, which is directly exposed to the Internet, you upload PHP source codes of photogallery. 

### Directory scructure

My webhosting provider supports some location for private files (not exposed to the Internet) and some location (in my case folder ```sub``` for subdomains) which is exposed to the Internet: 

* ```files``` - folder with private files
    * ```photogallery-on-php``` - name of my subdomain/photogallery
	    * ```some-album-1```
		    * ```photo``` - large photos which will be displaed
			* ```thumb``` - small thumbs
			* ```discussion.txt``` - file contains discussion for photoalbum 
			* ```info_album.ini``` - information about photoalbum
			* ```info_photos.csv``` - information about single files
		* ```some-album-2```
		* ```discussion.txt``` - file contains discussion for photogallery
		* ```google_analytics.txt``` - [Google Analytics](https://www.google.com/analytics/) script
		* ```info_gallery.ini``` - information about photogallery and its configuration
		* ```password.txt``` - password for access to the photogallery

* ```sub``` - folder with subdomain exposed to the Internet
    * ```photogallery-on-php``` - name of my subdomain/photogallery
	    * subdomain contains all photogallery-on-php [source codes](https://github.com/antonbalucha/photogallery-on-php/tree/master/sub/photogallery-on-php). You can just copy it there.

### Modification for your webhosting

If you do not wish to use ```files``` or ```sub``` directory, you have to change the paths in each php file separately. When [#16](https://github.com/antonbalucha/photogallery-on-php/issues/16) will be fixed/done, paths will be centralized and any modification will be much simpler. 
		
## Getting the Photogallery on PHP

Run ```git clone git@github.com:antonbalucha/photogallery-on-php``` command from your console, which supports GIT (e.g. https://git-scm.com/downloads)

## Is there any live demo?

You can find live demo on [https://photogallery-on-php.tonyb.technology](https://photogallery-on-php.tonyb.technology). Password for access is ```Test1```

# In conclusion

## License

I provide this project under [Apache License 2.0](https://github.com/antonbalucha/photogallery-on-php/blob/master/LICENSE).

## Contact

In case of any questions about the Photogallery On PHP or suggestions for improvements or some feedback or whatever is in your mind about the Photogallery On PHP you may contact me on ```projects@tonyb.technology```.

## Keywords

PHP, Photogallery On PHP, automatically generated photogallery, simple photogallery
