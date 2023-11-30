<?php

namespace Database\Seeders;

use App\Models\Stage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   /* */
       
        //Клиент
        Stage::create(['stage'=>'Открытие.ПРОСЧЕТ.Клиент']);
        Stage::create(['stage'=>'Потребности.ПРОСЧЕТ.Клиент']);
        Stage::create(['stage'=>'Презентация.ПРОСЧЕТ.Клиент']);
        Stage::create(['stage'=>'Закрытие.ПРОСЧЕТ.Клиент']);
        Stage::create(['stage'=>'ПРОСЧЕТ.Клиент']);
        //*******
        Stage::create(['stage'=>'Открытие.КП.Клиент']);
        Stage::create(['stage'=>'Потребности.КП.Клиент']);
        Stage::create(['stage'=>'Презентация.КП.Клиент']);
        Stage::create(['stage'=>'Закрытие.КП.Клиент']);
        Stage::create(['stage'=>'КП.Клиент']);
        //*******
        Stage::create(['stage'=>'Открытие.ЗАКАЗ.Клиент']);
        Stage::create(['stage'=>'Потребности.ЗАКАЗ.Клиент']);
        Stage::create(['stage'=>'Презентация.ЗАКАЗ.Клиент']);
        Stage::create(['stage'=>'Закрытие.ЗАКАЗ.Клиент']);
        Stage::create(['stage'=>'ЗАКАЗ.Клиент']);
        //*******
        Stage::create(['stage'=>'Открытие.ДЕНЬГИ.Клиент']);
        Stage::create(['stage'=>'Потребности.ДЕНЬГИ.Клиент']);
        Stage::create(['stage'=>'Презентация.ДЕНЬГИ.Клиент']);
        Stage::create(['stage'=>'Закрытие.ДЕНЬГИ.Клиент']);
        Stage::create(['stage'=>'ДЕНЬГИ.Клиент']);
        //База
        Stage::create(['stage'=>'Открытие.ПРОСЧЕТ.База']);
        Stage::create(['stage'=>'Потребности.ПРОСЧЕТ.База']);
        Stage::create(['stage'=>'Презентация.ПРОСЧЕТ.База']);
        Stage::create(['stage'=>'Закрытие.ПРОСЧЕТ.База']);
        Stage::create(['stage'=>'ПРОСЧЕТ.База']);
        //*******
        Stage::create(['stage'=>'Открытие.КП.База']);
        Stage::create(['stage'=>'Потребности.КП.База']);
        Stage::create(['stage'=>'Презентация.КП.База']);
        Stage::create(['stage'=>'Закрытие.КП.База']);
        Stage::create(['stage'=>'КП.База']);
        //*******
        Stage::create(['stage'=>'Открытие.ЗАКАЗ.База']);
        Stage::create(['stage'=>'Потребности.ЗАКАЗ.База']);
        Stage::create(['stage'=>'Презентация.ЗАКАЗ.База']);
        Stage::create(['stage'=>'Закрытие.ЗАКАЗ.База']);
        Stage::create(['stage'=>'ЗАКАЗ.База']);
        //*******
        Stage::create(['stage'=>'Открытие.ДЕНЬГИ.База']);
        Stage::create(['stage'=>'Потребности.ДЕНЬГИ.База']);
        Stage::create(['stage'=>'Презентация.ДЕНЬГИ.База']);
        Stage::create(['stage'=>'Закрытие.ДЕНЬГИ.База']);
        Stage::create(['stage'=>'ДЕНЬГИ.База']);
        //Остывший
        Stage::create(['stage'=>'Открытие.ПРОСЧЕТ.Остывший']);
        Stage::create(['stage'=>'Потребности.ПРОСЧЕТ.Остывший']);
        Stage::create(['stage'=>'Презентация.ПРОСЧЕТ.Остывший']);
        Stage::create(['stage'=>'Закрытие.ПРОСЧЕТ.Остывший']);
        Stage::create(['stage'=>'ПРОСЧЕТ.Остывший']);
        //*******
        Stage::create(['stage'=>'Открытие.КП.Остывший']);
        Stage::create(['stage'=>'Потребности.КП.Остывший']);
        Stage::create(['stage'=>'Презентация.КП.Остывший']);
        Stage::create(['stage'=>'Закрытие.КП.Остывший']);
        Stage::create(['stage'=>'КП.Остывший']);
        //*******
        Stage::create(['stage'=>'Открытие.ЗАКАЗ.Остывший']);
        Stage::create(['stage'=>'Потребности.ЗАКАЗ.Остывший']);
        Stage::create(['stage'=>'Презентация.ЗАКАЗ.Остывший']);
        Stage::create(['stage'=>'Закрытие.ЗАКАЗ.Остывший']);
        Stage::create(['stage'=>'ЗАКАЗ.Остывший']);
        //*******
        Stage::create(['stage'=>'Открытие.ДЕНЬГИ.Остывший']);
        Stage::create(['stage'=>'Потребности.ДЕНЬГИ.Остывший']);
        Stage::create(['stage'=>'Презентация.ДЕНЬГИ.Остывший']);
        Stage::create(['stage'=>'Закрытие.ДЕНЬГИ.Остывший']);
        Stage::create(['stage'=>'ДЕНЬГИ.Остывший']);
         //Новый
         Stage::create(['stage'=>'Открытие.ПРОСЧЕТ.Новый']);
         Stage::create(['stage'=>'Потребности.ПРОСЧЕТ.Новый']);
         Stage::create(['stage'=>'Презентация.ПРОСЧЕТ.Новый']);
         Stage::create(['stage'=>'Закрытие.ПРОСЧЕТ.Новый']);
         Stage::create(['stage'=>'ПРОСЧЕТ.Новый']);
         //*******
         Stage::create(['stage'=>'Открытие.КП.Новый']);
         Stage::create(['stage'=>'Потребности.КП.Новый']);
         Stage::create(['stage'=>'Презентация.КП.Новый']);
         Stage::create(['stage'=>'Закрытие.КП.Новый']);
         Stage::create(['stage'=>'КП.Новый']);
         //*******
         Stage::create(['stage'=>'Открытие.ЗАКАЗ.Новый']);
         Stage::create(['stage'=>'Потребности.ЗАКАЗ.Новый']);
         Stage::create(['stage'=>'Презентация.ЗАКАЗ.Новый']);
         Stage::create(['stage'=>'Закрытие.ЗАКАЗ.Новый']);
         Stage::create(['stage'=>'ЗАКАЗ.Новый']);
         //*******
         Stage::create(['stage'=>'Открытие.ДЕНЬГИ.Новый']);
         Stage::create(['stage'=>'Потребности.ДЕНЬГИ.Новый']);
         Stage::create(['stage'=>'Презентация.ДЕНЬГИ.Новый']);
         Stage::create(['stage'=>'Закрытие.ДЕНЬГИ.Новый']);
         Stage::create(['stage'=>'ДЕНЬГИ.Новый']);
       
    }
}
