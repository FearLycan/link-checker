<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\View;

$this->title = 'Function Two'

?>

    <div class="function-one">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            2. Podajemy listę adresów www, słów kluczowych i linków w polu tekstowym (jedno zadanie na linię) - np. w
            formacie ADRES [TABULACJA] SŁOWO KLUCZOWE [TABULACJA] LINK.
            Skrypt ma za zadanie wejść na LINK i sprawdzić czy znajduje się tam odnośnik
            (<?= Html::encode('<a href="ADRES">SŁOWO KLUCZOWE</a>') ?>).
            W wynikach dobrze by było aby wyświetlało czy ten link posiada atrybut rel="nofollow".
        </p>
        <?= $this->render('_forms/one', [
            'model' => $model,
        ]) ?>
    </div>


<?php $this->beginBlock('script') ?>
    <script>
        $("#textarea").keydown(function(e) {
            if(e.keyCode === 9) { // tab was pressed
                // get caret position/selection
                var start = this.selectionStart;
                var end = this.selectionEnd;

                var $this = $(this);
                var value = $this.val();

                // set textarea value to: text before caret + tab + text after caret
                $this.val(value.substring(0, start)
                    + "\t"
                    + value.substring(end));

                // put caret at right position again (add one for the tab)
                this.selectionStart = this.selectionEnd = start + 1;

                // prevent the focus lose
                e.preventDefault();
            }
        });
    </script>
<?php $this->endBlock() ?>