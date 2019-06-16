<?php

use app\models\Links;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var array $links */
$this->title = 'Results Two';
?>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" data-main-id="<?= $id ?>">
        <?php foreach ($links as $key => $link): ?>

            <div class="panel panel-default" id="<?= $key ?>" data-url="<?= $link->url ?>"
                 data-key="<?= $link->key ?>" data-link="<?= $link->link ?>" data-id="<?= $key ?>">
                <div class="panel-heading" role="tab" id="headingOne<?= $key ?>">
                    <div class="row">
                        <div class="col-md-10">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseOne<?= $key ?>"
                                   aria-expanded="true" aria-controls="collapseOne">
                                    <?= Html::encode($link->url) ?>
                                </a>
                            </h4>
                        </div>

                        <div class="col-md-2">
                       <span class="loading">
                            <img src="<?= Url::to('@web/images/ajax-loader.gif') ?>">
                       </span>
                            <span style="display: none;" class="success glyphicon glyphicon-ok"
                                  aria-hidden="true"></span>
                            <span style="display: none;" class="error glyphicon glyphicon-exclamation-sign"
                                  aria-hidden="true"></span>
                        </div>
                    </div>
                </div>
                <div id="collapseOne<?= $key ?>" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="headingOne<?= $key ?>">
                    <div class="panel-body">

                        <ul>
                            <?php foreach ((array)$link as $n => $item): ?>
                                <li><?= $n ?> - <?= $item ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <ul class="results"></ul>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


<?php $this->beginBlock('script') ?>
    <script>
        $('div.panel-default').each(function (index, value) {
            var url = $(this).data('url');
            var key = $(this).data('key');
            var link = $(this).data('link');
            var id = $(this).data('id');

            //console.log(key);


            process(url, key, link, id);
        });

        function process(url, key, link, id) {

            $.ajax({
                url: '<?= Url::to(['process/two']) ?>',
                dataType: 'json',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                data: {url: url, link: link, key: key},
                success: function (data, textStatus, jQxhr) {
                    $('#' + id).find('span.loading').hide();

                    console.log(data);
                    var results = '';
                    if (data['status'] === 'ERROR') {
                        $('#' + id).find('span.error').show();
                        results = '<li> STATUS: ' + data['status'] + '</li>';
                        results = results + '<li>' + data['message'] + '</li>';
                    } else {
                        $('#' + id).find('span.success').show();
                        console.log('eee');
                        $.each(data['results'], function (index, value) {
                            results = results + '<li>' + index + ': ' + value + '</li>';
                        });
                    }

                    $('#' + id).find('ul.results').append(results);
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                    $('#' + id).find('span.loading').show();
                }
            });
        }
    </script>
<?php $this->endBlock() ?>