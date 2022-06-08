<?php

use kartik\date\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;

?>
<div class="card">
    <div class="card-body register-card-body">
        <p class="login-box-msg"><?= \Yii::t('auth', 'Register a new membership') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'register-form']) ?>

        <?= $form->field($model, 'firstName', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => \Yii::t('auth', 'First Name')]) ?>


        <?= $form->field($model, 'lastName', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => \Yii::t('auth', 'Last Name')]) ?>


        <?= $form->field($model, 'email', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => \Yii::t('auth', 'Email')]) ?>



        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => \Yii::t('auth', 'Password')]) ?>

        <?= $form->field($model, 'password2', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => \Yii::t('auth', 'Password2')]) ?>



        <?php
        echo $form->field($model, 'occupation')->widget(\kartik\widgets\Select2::class, [
            'data' => \yii\helpers\ArrayHelper::map(
                $formDropdowns->occupation,
                'id',
                'name'
            ),
            'model' => $model,
            'attribute' => 'occupation',
            'options' => ['placeholder' => \Yii::t('auth', 'Job')],
            'pluginOptions' => [
                'allowClear' => false,
            ], 'pluginEvents' => [
                "change" => "function() {
                                            $('#occupation_id').val($( this ).val());
                                            if($('#occupation_id').val() == 1 || $('#occupation_id').val() == 2) {
                                                $('#areaofspecialization_block').show();
                                            } else {
                                                $('#areaofspecialization_block').hide();
                                            }
                                        }"
            ]
        ])->label('');
        ?>
        <input type="hidden" id="occupation_id" value="<?php echo $model->occupation; ?>">


        <span style="<?php echo $model->occupation != 1 ? 'display:none2;' : ''; ?>" id="areaofspecialization_block">
                                <?php
                                echo $form->field($model, 'areaofspecialization')->widget(\kartik\select2\Select2::class, [
                                    'data' => \yii\helpers\ArrayHelper::map(
                                        $formDropdowns->areaOfSpecialization,
                                        'id',
                                        'name'
                                    ),
                                    'model' => $model,
                                    'attribute' => 'areaofspecialization',
                                    'options' => ['placeholder' => \Yii::t('auth', 'Specialization')],
                                    'pluginOptions' => [
                                        'allowClear' => false
                                    ],
                                ])->label('');
                                ?>
                            </span>


        <?= $form->field($model, 'userAgreement')->checkbox([
            'template' => '<div class="icheck-primary">{input}{label}</div>',
            'labelOptions' => [
                'class' => ''
            ],
            'uncheck' => null,
            'checked' => false,
            'required' => true
        ])->label('<a href="#" onclick="showModal()" data-toggle="modal" data-target="#sozlesmeModal" > ' . \Yii::t('auth', 'I Approve User Agreement and Privacy Policy') . '</a>') ?>


        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block"><?= \Yii::t('auth', 'Register') ?></button>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

    <a href="/auth/account/login" class="text-center"><?= \Yii::t('auth', 'I already have a membership') ?></a>

    <br/>
</div>
<!-- /.login-card-body -->

<script type="text/javascript">
    function showModal() {
        $('#passenger_modal').modal('show');
        $('#passenger_modal_content').load("<?=Yii::getAlias('@web')?>/auth/account/agreement");
    }
</script>

<?php
Modal::begin([
    'id' => 'passenger_modal',
    'size' => 'modal-lg',
    'title' => \Yii::t('auth', 'Agreement'),
]);

echo '<div id="passenger_modal_content"><div>';
Modal::end();
?>

</div>

