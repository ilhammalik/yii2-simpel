<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\ArrayHelper;
use \common\components\MyHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \common\models\DaftarUnit;
use \common\components\HelperUnit;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WpPostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Home');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="block">
    <div class="block-title">
        <h2><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="wp-posts-index">



    	<h2 align="center">Realisasi Perjalanan Dinas per Satuan Kerja T.A.</h2>
           <h4 align="center">
            <?php
            $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
            ]);
            ?>
             <?php
            $thisYear = date('Y', time());
            if ($thisYear = '2015'){
                for ($yearNum = $thisYear; $yearNum >= 2015; $yearNum--) {
                $years[$yearNum] = $yearNum;
            }
            }
           
            ?>

            <select name="tahun" onchange="this.form.submit()">
                <?php
                foreach ($years as $key) {
                    echo '<option value="' . $key . '">' . $key . '</option>';
                }
                ?>

            </select>
        </h4>
<?php ActiveForm::end(); ?>




        <table class="table1" width="100%">
            <thead>
                <tr>
                    <th>Satuan Kerja</th>
                    <th scope="col" abbr="Starter"><center>Pagu</center></th>
            <th scope="col" abbr="Medium"><center>Realisasi</center></th>
            <th scope="col" abbr="Business"><center>Sisa</center></th>
            <th scope="col" abbr="Deluxe"><center>Prosen</center></th>
            </tr>
            </thead>
            <tfoot>

            </tfoot>
            <tbody>
                <?php
                $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
                $satker = DaftarUnit::find()->where('unit_id in ('.Yii::$app->user->identity->unit_id.')')->all();
                 
                foreach ($satker as $unit) {

                    ?>
                    <tr>
                        <td style="background-color: white;"  scope="row"></td>
                    </tr>
                    <tr>
                        <th scope="row"> <?= HelperUnit::Apagu($unit->unit_id) ?></th>
                       

                    </tr>

                    <?php
                    switch ($unit->unit_id) {
                        case 110000:
                            $satker = DaftarUnit::find()->where('satker_id=110000 and unit_id in (111000,112000,113000,114000,115000)')->all();
                            break;
                        case 120000:
                            $satker = DaftarUnit::find()->where(' unit_id in (121000,122000,123000,124000)')->all();
                            break;
                        case 130000:
                            $satker = DaftarUnit::find()->where('unit_id in (131000,132000,133000)')->all();
                            break;
                        case 161100:
                            $satker = DaftarUnit::find()->where('unit_id in (0)')->all();
                            break;
                        case 151000:
                            $satker = DaftarUnit::find()->where('unit_id=0')->all();
                            break;
                        default:
                            echo "";
                    }

                    foreach ($satker as $sat) {
                        ?>
                        <tr>
                            <th  width="240" bgcolor="gray" align="left">
                                <div class="pull-right">
                                    <?= HelperUnit::Apagu($sat->unit_id) ?>   
                                </div>

                            </th>
                            <td align="center"><?php
                            $pag = HelperUnit::Pagu($sat->unit_id);
                            $pagn = number_format(HelperUnit::Pagu($sat->unit_id),0,",",".");
                            echo $pagn;
                             ?>   
                             </td>
                            <td align="center">
                            	<?php
                            $re = HelperUnit::Real($sat->unit_id);
                            $ren = number_format(HelperUnit::Real($sat->unit_id),0,",",".");
                            echo $ren;
                             ?>  
                            </td>
                            <td align="center"><?= number_format($pag-$re,0,",","."); ?></td>
                            <td align="center"><?php 
                           		$data = @($re/$pag)*100;
                            	if(!empty($data)){
                            		echo number_format($data,0,",",".");
                            	}else{
                            		echo '0';
                            	}
                            ?> %</td>

                        </tr>


                    <?php } ?>
                <?php } ?>
                <tr>
                    <td style="background-color: white;"  scope="row"></td>
                </tr>





            </tbody>
        </table>




    </div>
</div>
<style type="text/css">
	th{
		text-align: center;
	}
</style>