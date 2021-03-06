@extends('user.layouts.app')

@section('title', 'Доставка и Оплата')

@section('content')

  <div class="container pt-5 pb-5">
    <div class="row">
      <div class="col-12">
        <h1 class="h3">Платежи. Оплата банковской картой онлайн</h1>
      </div>

      <div class="col-12">
        <p>Наш сайт подключен к интернет-эквайрингу, и Вы можете оплатить Услугу банковской картой Visa или Mastercard. После подтверждения выбранного Товара либо услуги откроется защищенное окно с платежной страницей процессингового центра CloudPayments, где Вам необходимо ввести данные Вашей банковской карты. Для дополнительной аутентификации держателя карты используется протокол 3-D Secure. Если Ваш Банк-эмитент поддерживает данную технологию, Вы будете перенаправлены на его сервер для прохождения дополнительной идентификации. Информацию о правилах и методах дополнительной идентификации уточняйте в Банке, выдавшем Вам банковскую карту.</p>
        <p class="mt-2">Услуга онлайн-оплаты осуществляется в соответствии с правилами Международных платежных систем Visa и MasterCard на принципах соблюдения конфиденциальности и безопасности совершения платежа, для этого используются самые актуальные методы проверки, шифрования и передачи данных по закрытым каналам связи. Ввод данных банковской карты осуществляется в защищенном окне на платежной странице CloudPayments.</p>
        <p class="mt-2">В поля на платежной странице требуется ввести номер карты, имя владельца карты, срок действия карты, трёхзначный код безопасности (CVV2 для VISA или CVC2 для MasterCard). Все необходимые данные отображены на поверхности банковской карты.</p>
        <p class="mt-2">CVV2/ CVC2 — это трёхзначный код безопасности, находящийся на оборотной стороне карты.</p>
        <p class="mt-2">Далее в том же окне откроется страница Вашего банка-эмитента для ввода 3-D Secure кода. В случае, если у вас не настроен статичный 3-D Secure, он будет отправлен на ваш номер телефона посредством SMS. Если 3-D Secure код к Вам не пришел, то следует обратиться в ваш банк-эмитент.</p>
        <p class="mt-2">3-D Secure — это самая современная технология обеспечения безопасности платежей по картам в сети интернет. Позволяет однозначно идентифицировать подлинность держателя карты, осуществляющего операцию, и максимально снизить риск мошеннических операций по карте.</p>

      </div>
      <div class="col-12 mt-4">
        <h3>Юридическое лицо</h3>
        <p class="mt-2">
          <strong>Реквизиты банка:</strong>
          <br>
          АО "Kaspi Bank"
          <br>
          CASPKZKA
          <br>
          890303300328
          <br>
          KZ44722S000001718569
        </p>
        <p class="mt-2">
          ИП WALLRIDE Юр. адрес г.Алматы мкрн. 10А 96/7 факт. адрес г.Алматы v мкрн. Самал 3 дом 1
        </p>
      </div>
      <div class="col-12 mt-4">
        <h3>Гарантии безопасности</h3>
        <p class="mt-2">Процессинговый центр CloudPayments защищает и обрабатывает данные Вашей банковской карты по стандарту безопасности PCI DSS 3.0. Передача информации в платежный шлюзпроисходит с применением технологии шифрования SSL. Дальнейшая передача информации происходит по закрытым банковским сетям, имеющим наивысший уровень надежности. CloudPayments не передает данные Вашей карты нам и иным третьим лицам. Для дополнительной аутентификации держателя карты используется протокол 3-D Secure</p>
        <p class="mt-2">В случае, если у Вас есть вопросы по совершенному платежу, Вы можете обратиться в службу поддержки клиентов платежного сервиса по электронной почте
          <a href="mailto:support@cloudpayments.kz">support@cloudpayments.kz</a>
        </p>

      </div>
      <div class="col-12 mt-4">
        <h3>Безопасность онлайн-платежей</h3>
        <p class="mt-2">Предоставляемая Вами персональная информация (имя, адрес, телефон, e-mail, номер кредитной карты) является конфиденциальной и не подлежит разглашению. Данные Вашей кредитной карты передаются только в зашифрованном виде и не сохраняются на нашем Web-сервере.</p>
        <p class="mt-2">Мы рекомендуем вам проверить, что ваш браузер достаточно безопасен для проведения платежей онлайн, на
          <a href="https://my.cloudpayments.ru/ru/browser">специальной странице</a> </p>
        <p class="mt-2">Безопасность обработки Интернет-платежей гарантирует ТОО «CloudPayments Kazakhstan». Все операции с платежными картами происходят в соответствии с требованиями VISA International, MasterCard и других платежных систем. При передаче информации используются специализированные технологии безопасности карточных онлайн-платежей, обработка данных ведется на безопасном высокотехнологичном сервере процессинговой компании.</p>
        <div class="row justify-content-center justify-content-md-start">
          <div class="col-auto col-md-3">
            <img src="{{ asset('images/mps.png') }}" alt="МПС" class="img-fluid mx-auto mx-md-0">
          </div>
        </div>
        <p class="mt-2">Оплата платежными картами безопасна, потому что:</p>
        <ul>
          <li>Система авторизации гарантирует покупателю, что платежные реквизиты его платежной карты (номер, срок действия, CVV2/CVC2) не попадут в руки мошенников, так как эти данные не хранятся на сервере авторизации и не могут быть похищены.</li>
          <li>Покупатель вводит свои платежные данные непосредственно в системе авторизации CloudPayments, а не на сайте интернет-магазина, следовательно, платежные реквизиты карточки покупателя не будут доступны третьим лицам.</li>
        </ul>
      </div>

      <div class="col-12 mt-4">
        <h3>Процедура оплаты</h3>
        <ul>
          <li>1. Перейти на страницу оплаты заказа</li>
          <li>2. Ввести все необходимые личные данные</li>
          <li>3. Выбрать метод доставки и способ оплаты</li>
          <li>4. Произвести оплату картой или наличными в магазине</li>
        </ul>
      </div>

      <div class="col-12 mt-4">
        <h3>Возврат денежных средств</h3>
        <p class="mt-2">При проведении онлайн-оплаты посредством платежных карт не допускается возврат наличными денежными средствами. Порядок возврата регулируется правилами международных платежных систем:</p>
        <ul>
          <li>Потребитель вправе отказаться от товара в любое время до его передачи, после передачи товара отказ необходимо оформить в течение 14 дней;</li>
          <li>Возврат товара надлежащего качества возможен в случае, если сохранены его товарный вид, потребительские свойства, а также документ, подтверждающий факт и условия покупки указанного товара;</li>
          <li>Потребитель не вправе отказаться от товара надлежащего качества, имеющего индивидуально-определенные свойства, если указанный товар может быть использован исключительно приобретающим его человеком;</li>
          <li>При отказе от товара со стороны потребителя продавец должен вернуть ему денежную сумму, уплаченную потребителем, не позднее чем через десять дней со дня предъявления потребителем соответствующего требования</li>
        </ul>
        <p class="mt-2">
          Для возврата денежных средств на банковскую карту необходимо заполнить «Заявление о возврате денежных средств», которое высылается по требованию компанией на электронный адрес, и отправить его вместе с приложением копии документа, удостоверяющего личность, по адресу
          <a href="mailto:info@wallridestore.com">info@wallridestore.com</a>
        </p>
        <p class="mt-2">
          Возврат денежных средств будет осуществлен на банковскую карту в течении 7 рабочих дней со дня получения «Заявление о возврате денежных средств» Компанией.
        </p>
        <p class="mt-2">
          Для возврата денежных средств по операциям, проведенным с ошибками, необходимо обратиться с письменным заявлением и приложением копии документа, удостоверяющего личность, и чеков/квитанций, подтверждающих ошибочное списание. Данное заявление необходимо направить по адресу <a href="mailto:info@wallridestore.com">info@wallridestore.com</a>
        </p>
        <p class="mt-2">Сумма возврата будет равняться сумме покупки. Срок рассмотрения Заявления и возврата денежных средств начинает исчисляться с момента получения Компанией Заявления и рассчитывается в рабочих днях без учета праздников/выходных дней.</p>
      </div>

      <div class="col-12 mt-4">
        <h3>Случаи отказа в совершении платежа:</h3>
        <ul>
          <li>банковская карта не предназначена для совершения платежей через интернет, о чем можно узнать, обратившись в Ваш Банк-эмитент;</li>
          <li>недостаточно средств для оплаты на банковской карте. Подробнее о наличии средств на платежной карте Вы можете узнать, обратившись в банк, выпустивший банковскую карту;</li>
          <li>данные банковской карты введены неверно;</li>
          <li>истек срок действия банковской карты. Срок действия карты, как правило, указан на лицевой стороне карты (это месяц и год, до которого действительна карта). Подробнее о сроке действия карты Вы можете узнать, обратившись в банк-эмитент.</li>

        </ul>
        <p class="mt-2">По вопросам оплаты с помощью банковской карты и иным вопросам, связанным с работой сайта, Вы можете обратиться по следующим телефонам
          <a href="tel:+7(747) 556-23-83">+7(747) 556-23-83</a> </p>
      </div>

      <div class="col-12 mt-4">
        <h3>Конфиденциальность</h3>
        <p class="mt-2">1. Определения</p>
        <p class="mt-2">Интернет-проект www.wallridestore.com (далее – URL, «мы») серьезно относится к вопросу конфиденциальности информации своих клиентов и посетителей сайта www.wallridestore.com (далее – «вы», «посетители сайта»). Персонифицированной мы называем информацию, содержащую персональные данные (например: ФИО, логин или название компании) посетителя сайта, а также информацию о действиях, совершаемых вами на сайте URL. (например: заказ посетителя сайта с его контактной информацией). Анонимными мы называем данные, которые невозможно однозначно идентифицировать с конкретным посетителем сайта (например: статистика посещаемости сайта).</p>
        <p class="mt-2">2. Использование информации</p>
        <p class="mt-2">
          Мы используем персонифицированную информацию конкретного посетителя сайта исключительно для обеспечения ему качественного оказания услуг и их учета. Мы не раскрываем персонифицированных данных одних посетителей сайта URL другим посетителям сайта. Мы никогда не публикуем персонифицированную информацию в открытом доступе и не передаем ее третьим лицам. Исключением являются лишь ситуации, когда предоставление такой информации уполномоченным государственным органам предписано действующим законодательством Республики Казахстан. Мы публикуем и распространяем только отчеты, построенные на основании собранных анонимных данных. При этом отчеты не содержат информацию, по которой было бы возможным идентифицировать персонифицированные данные пользователей услуг. Мы также используем анонимные данные для внутреннего анализа, целью которого является развитие продуктов и услуг URL.
        </p>
        <p class="mt-2">3. Ссылки</p>
        <p class="mt-2">Сайт www.wallridestore.com может содержать ссылки на другие сайты, не имеющие отношения к нашей компании и принадлежащие третьим лицам. Мы не несем ответственности за точность, полноту и достоверность сведений, размещенных на сайтах третьих лиц, и не берем на себя никаких обязательств по сохранению конфиденциальности информации, оставленной вами на таких сайтах.</p>
        <p class="mt-2">4. Ограничение ответственности</p>
        <p class="mt-2">Мы делаем все возможное для соблюдения настоящей политики конфиденциальности, однако, мы не можем гарантировать сохранность информации в случае воздействия факторов, находящихся вне нашего влияния, результатом действия которых станет раскрытие информации. Сайт www.wallridestore.com z и вся размещенная на нем информация представлены по принципу "как есть”, без каких-либо гарантий. Мы не несем ответственности за неблагоприятные последствия, а также за любые убытки, причиненные вследствие ограничения доступа к сайту URL или вследствие посещения сайта и использования размещенной на нем информации.</p>
        <p class="mt-2">5. Контакты</p>
        <p class="mt-2">По вопросам, касающимся настоящей политики, просьба обращаться по адресу <a href="mailto:info@wallridestore.com">info@wallridestore.com</a></p>

      </div>


    </div>
  </div>

@endsection
