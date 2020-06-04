<div class ="container">
    <div class="row">
        <div class = "col-md-12 show_item table-responsive">
                <table class  = "table table-hover  table-bordered table-condensed">
                    <caption>Курс валют БЕЛАРУСБАНК</caption>
                      <thead > 
                        <tr>
                            <th>Доллар, покупка</th>
                            <th>Доллар, продажа</th>
                            <th>Евро, покупка</th>                        
                            <th>Евро, продажа</th>
                            <th>Рос.рубль, покупка</th>                        
                            <th>Рос.рубль, продажа</th>
                            <th>Адрес</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            foreach ($info as $d){
                                    echo '<tr>
                                             <td>'.$d['USD_in'].' </td>
                                             <td>'.$d['USD_out'].' </td>
                                             <td>'.$d['EUR_in'].' </td>
                                             <td>'.$d['EUR_out'].' </td>
                                             <td>'.$d['RUB_in'].' </td>
                                             <td>'.$d['RUB_out'].' </td>
                                             <td>'.$d['street'].','.$d['home_number'].' </td>
                                          </tr>';  
                                }
                    ?>
                    </tbody>
                </table>
        </div>
    </div>   
</div>