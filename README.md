# survey-slim

*Em construção

Sobre:
- Sistema de enquete dinâmica utilizando 'votos por estrelas'. Basicamente se trata de criar enquetes com determinadas perguntas para que outros possam responde-las dando de 1 a 5 estrelas.
- Pode ser utilizado em seu dia-a-dia, em empresas com pesquisas de satisfação e etc.


composer.json
{
    "require": {
        "slim/slim": "^3.0",
        "slim/twig-view": "^2.1",
        "illuminate/database": "^5.2",
        "respect/validation": "^1.1",
        "slim/csrf": "^0.6.0",
        "slim/flash": "^0.1.0"
    },
    "autoload": {
    	"psr-4": {
    		"App\\": "app"
    	}
    }
}
