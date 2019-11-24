<?php 
namespace App\Extension;

use Encore\Admin\Form\Field;
/**
 * 	富文本编辑器
 */
class WangEditor extends Field
{
	/**
	 *	视图
	 */
	protected $view = 'admin.wang_editor';

	/**
	 *	加载js
	 */
	protected $js = [
		'/vendor/laravel-admin-ext/wang-editor/wangEditor-3.0.10/release/wangEditor.min.js',
	];

	/**
	 *	渲染
	 */
	public function render()
	{
		$name = $this->formatName($this->column);
		$this->script = <<<EOT
var E = window.wangEditor
var editor = new E('#{$this->id}');
editor.customConfig.onchange = function (html) {
    $('input[name=\'$name\']').val(html);
}
editor.create()
EOT;
		return parent::render();
	}
}