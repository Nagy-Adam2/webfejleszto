<?php

require_once("controller.php");

$bootstrapContainer = 'container';
$bootstrapRow = 'row';
$bootstrapCol = 'col';
$divContainerBegin = '<div class='.$bootstrapContainer.'>';
$divContainerEnd = '</div>';
$divRowBegin = '<div class='.$bootstrapRow.'>';
$divRowEnd = '</div>';
$divColBegin = '<div class='.$bootstrapCol.'>';
$divColEnd = '</div>';
$headingNumberViewCenter = 'text-align: center';
$headingNumberViewText = 'Adag megadása';
$headingTwoNumberView = '<h2 style='.$headingNumberViewCenter.'>'.$headingNumberViewText.'</h2>';
$rowBreak = '<br />';
$inputSubmit = 'submit';
$inputNameSubmit = 'upload';
$inputValue = 'Küldés';
$methodPost = 'post';
$enctypeMultipartFormData = 'multipart/form-data';
$labelText = 'Adag megadása:';
$labelFor = 'inputNumber';
$formLabelClass = "form-label";
$labelInput = '<label for='.$labelFor.' class='.$formLabelClass.'>'.$labelText.'</label>';
$inputNumberId = 'inputNumber';
$inputNumberName = 'inputNumber';
$numberType = 'number';
$minValue= '0';
$formControlInput = 'form-control';
$inputMarginTop = 'mt-1';
$submitBackgroundColorBtn = 'btn';
$submitBackgroundColorSuccess = 'btn-success';
$inputNumber = '<input type='.$numberType.' id='.$inputNumberId.' name='.$inputNumberName.' min='.$minValue.' class='.$formControlInput.' value=0 />';
$inputSubmitTag = '<input type='.$inputSubmit.' name='.$inputNameSubmit.' class=\''.$formControlInput.' '.$submitBackgroundColorBtn.' '.$submitBackgroundColorSuccess.' '.$inputMarginTop.'\' value='.$inputValue.' />';

$formCompleteInput = '<form method='.$methodPost.' enctype='.$enctypeMultipartFormData.'>'
      .$labelInput.$rowBreak
      .$inputNumber.$rowBreak
      .$inputSubmitTag.$rowBreak.
'</form>';

echo $divContainerBegin;
echo $divRowBegin;
echo $divColBegin;

$InputNumberView = functionInputNumberPost(isset($inputNumberPost) ? $inputNumberPost : 0);
$paragraphTagInputNumberView = '<p class=\'fs-2 fw-bold my-2\'>'.$InputNumberView.'</p>';
echo $paragraphTagInputNumberView;
echo $headingTwoNumberView;
echo $formCompleteInput;
        
echo $divContainerEnd;
echo $divRowEnd;
echo $divColEnd;

?>