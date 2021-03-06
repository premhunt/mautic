<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
?>
<!-- start: trigger type event -->
<ul class="list-group campaign-event-list">
    <?php if (isset($events) && is_array($events)) : ?>
        <?php foreach ($events as $event) : ?>
        	<?php if ($event['eventType'] == $eventType) : ?>
	            <li class="list-group-item bg-auto bg-light-xs">
	                <div class="progress-bar progress-bar-success" style="width:<?php echo $event['percent']; ?>%"></div>
	                <div class="box-layout">
	                    <div class="col-md-1 va-m">
	                        <h3>
	                            <?php if ($event['eventType'] == 'decision') : ?>
	                                <span class="fa fa-bullseye text-danger"></span>
	                            <?php else : ?>
	                                <span class="fa fa-rocket text-success"></span>
	                            <?php endif; ?>
	                        </h3>
	                    </div>
	                    <div class="col-md-7 va-m">
	                        <h5 class="fw-sb text-primary mb-xs">
	                            <?php echo $event['name']; ?>
	                            <small><?php echo $event['percent']; ?> %</small>
	                        </h5>
	                        <h6 class="text-white dark-sm"><?php echo $event['description']; ?></h6>
	                    </div>
	                    <div class="col-md-4 va-m text-right">
	                        <em class="text-white dark-sm"><?php echo $view['translator']->trans('mautic.campaign.' . $event['type']); ?></em>
	                    </div>
	                </div>
	            </li>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
<!--/ end: trigger type event -->
