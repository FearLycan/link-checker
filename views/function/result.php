<?php

use app\models\Links;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var array $links */
$this->title = 'Results';
?>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <?php foreach ($links as $key => $link): ?>

            <div class="panel panel-default" id="<?= $key ?>" data-url="<?= $link ?>" data-id="<?= $key ?>">
                <div class="panel-heading" role="tab" id="headingOne<?= $key ?>">
                    <div class="row">
                        <div class="col-md-10">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseOne<?= $key ?>"
                                   aria-expanded="true" aria-controls="collapseOne">
                                    <?= Html::encode($link) ?>
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
            var id = $(this).data('id');
            process(id, url);
        });

        function process(id, url) {

            $.ajax({
                url: '<?= Url::to(['process/one']) ?>',
                dataType: 'json',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                data: {url: url},
                success: function (data, textStatus, jQxhr) {
                    $('#' + id).find('span.loading').hide();

                    console.log(data);
                    var results = '';
                    if(data['status'] === 'ERROR'){
                        $('#' + id).find('span.error').show();
                        results = '<li> STATUS: ' + data['status'] + '</li>';
                        results = results + '<li>' + data['message'] + '</li>';
                    }else{
                        $('#' + id).find('span.success').show();
                        $.each(data['results'], function (index, value) {
                            results = results + '<li>' + index + ': ' + value + '</li>';
                        });
                    }

                    $('#' + id).find('ul').append(results);
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                    $('#' + id).find('span.loading').show();
                }
            });
        }
    </script>
<?php $this->endBlock() ?>