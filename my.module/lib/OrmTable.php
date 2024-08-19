<?php

namespace My\Module;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\StringField,
	Bitrix\Main\ORM\Fields\Validators\LengthValidator;

Loc::loadMessages(__FILE__);

/**
 * Class TableTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> CODEWORD string(255) mandatory
 * <li> USER string(255) mandatory
 * </ul>
 *
 * @package Bitrix\Module
 **/

class OrmTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'my_module_table';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			new IntegerField(
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('TABLE_ENTITY_ID_FIELD')
				]
			),
			new StringField(
				'CODEWORD',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateCodeword'],
					'title' => Loc::getMessage('TABLE_ENTITY_CODEWORD_FIELD')
				]
			),
			new StringField(
				'USER',
				[
					'required' => true,
					'validation' => [__CLASS__, 'validateUser'],
					'title' => Loc::getMessage('TABLE_ENTITY_USER_FIELD')
				]
			),
		];
	}

	/**
	 * Returns validators for CODEWORD field.
	 *
	 * @return array
	 */
	public static function validateCodeword()
	{
		return [
			new LengthValidator(null, 255),
		];
	}

	/**
	 * Returns validators for USER field.
	 *
	 * @return array
	 */
	public static function validateUser()
	{
		return [
			new LengthValidator(null, 255),
		];
	}
}