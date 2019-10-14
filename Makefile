PORT ?= 8000

##
##Server
##
server:
	php -S localhost:$(PORT) -t public/ -d display_errors=1