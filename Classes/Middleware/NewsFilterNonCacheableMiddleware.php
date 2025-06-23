<?php
namespace GeorgRinger\NewsFilter\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\ApplicationType;

class NewsFilterNonCacheableMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (ApplicationType::fromRequest($request)->isFrontend()) {
            $vars = $request->getParsedBody()['tx_news_pi1'] ?? [];
            if (isset($vars['search']) && is_array($vars['search'])) {
                foreach (['Pi1', 'NewsListSticky', 'NewsSelectedList'] as $pluginName) {
                    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['News']['plugins'][$pluginName]['controllers'][\GeorgRinger\News\Controller\NewsController::class]['nonCacheableActions'][] = 'list';
                }
            }
        }

        return $handler->handle($request);
    }
}

