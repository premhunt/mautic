<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic, NP. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\AssetBundle;

/**
 * Class AssetEvents
 * Events available for AssetBundle
 *
 * @package Mautic\AssetBundle
 */
final class AssetEvents
{

    /**
     * The mautic.asset_on_hit event is thrown when a public asset is browsed and a hit recorded in the analytics table
     *
     * The event listener receives a
     * Mautic\AssetBundle\Event\AssetHitEvent instance.
     *
     * @var string
     */
    const ASSET_ON_HIT   = 'mautic.asset_on_hit';


    /**
     * The mautic.asset_on_upload event is thrown before uploading a file
     *
     * The event listener receives a
     * Mautic\AssetBundle\Event\AssetEvent instance.
     *
     * @var string
     */
    const ASSET_ON_UPLOAD   = 'mautic.asset_on_upload';

    /*
     * The mautic.asset_on_display event is thrown before displaying the asset content
     *
     * The event listener receives a
     * Mautic\AssetBundle\Event\AssetEvent instance.
     *
     * @var string
     */
    const ASSET_ON_DISPLAY   = 'mautic.asset_on_display';

    /**
     * The mautic.asset_pre_save event is thrown right before a asset is persisted.
     *
     * The event listener receives a
     * Mautic\AssetBundle\Event\AssetEvent instance.
     *
     * @var string
     */
    const ASSET_PRE_SAVE   = 'mautic.asset_pre_save';

    /**
     * The mautic.asset_post_save event is thrown right after a asset is persisted.
     *
     * The event listener receives a
     * Mautic\AssetBundle\Event\AssetEvent instance.
     *
     * @var string
     */
    const ASSET_POST_SAVE   = 'mautic.asset_post_save';

    /**
     * The mautic.asset_pre_delete event is thrown prior to when a asset is deleted.
     *
     * The event listener receives a
     * Mautic\AssetBundle\Event\AssetEvent instance.
     *
     * @var string
     */
    const ASSET_PRE_DELETE   = 'mautic.asset_pre_delete';


    /**
     * The mautic.asset_post_delete event is thrown after a asset is deleted.
     *
     * The event listener receives a
     * Mautic\AssetBundle\Event\AssetEvent instance.
     *
     * @var string
     */
    const ASSET_POST_DELETE   = 'mautic.asset_post_delete';

    /**
     * The mautic.category_pre_save event is thrown right before a category is persisted.
     *
     * The event listener receives a
     * Mautic\AssetBundle\Event\CategoryEvent instance.
     *
     * @var string
     */
    const CATEGORY_PRE_SAVE   = 'mautic.category_pre_save';

    /**
     * The mautic.category_post_save event is thrown right after a category is persisted.
     *
     * The event listener receives a
     * Mautic\AssetBundle\Event\CategoryEvent instance.
     *
     * @var string
     */
    const CATEGORY_POST_SAVE   = 'mautic.category_post_save';

    /**
     * The mautic.category_pre_delete event is thrown prior to when a category is deleted.
     *
     * The event listener receives a
     * Mautic\AssetBundle\Event\CategoryEvent instance.
     *
     * @var string
     */
    const CATEGORY_PRE_DELETE   = 'mautic.category_pre_delete';


    /**
     * The mautic.category_post_delete event is thrown after a category is deleted.
     *
     * The event listener receives a
     * Mautic\AssetBundle\Event\CategoryEvent instance.
     *
     * @var string
     */
    const CATEGORY_POST_DELETE   = 'mautic.category_post_delete';
}