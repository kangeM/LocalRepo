<?php if (Yii::$app->session->hasFlash('warning')): ?>
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="glyphicon glyphicon-record"></span> <strong>Warning Message</strong>
                    <div class="clearfix"></div>
                    <p><?= Yii::$app->session->getFlash('warning') ?></p>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="glyphicon glyphicon-record"></span> <strong>Success Message</strong>
                    <div class="clearfix"></div>
                    <p><?= Yii::$app->session->getFlash('success') ?></p>
                </div>
            </div>
            <?php endif; ?>
                                
            <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="glyphicon glyphicon-record"></span> <strong>Error Message</strong>
                    <div class="clearfix"></div>
                    <p><?= Yii::$app->session->getFlash('error') ?></p>
                </div>
            </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('info')): ?>
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="glyphicon glyphicon-record"></span> <strong>Info Message</strong>
                    <div class="clearfix"></div>
                    <p><?= Yii::$app->session->getFlash('info') ?></p>
                </div>
            </div>
            <?php endif; ?>