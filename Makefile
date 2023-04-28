copy:
	@docker cp "shopware:/var/www/html/vendor/." "./shopware-vendor"
up:
	@docker-compose down
	@docker-compose up -d
    @mutagen sync create -c mutagen.yaml --name=plugin-code "./plugins" "docker://shopware/var/www/html/custom/plugins"
down:
	@docker-compose down
con:
	@docker exec -it shopware /bin/bash