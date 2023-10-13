<?php

/**
 * The MIT License.
 *
 * Copyright (c) 2023 "YooMoney", NBСO LLC
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace YooKassa\Request\Payments\PaymentData;

use YooKassa\Model\Payment\PaymentMethod\B2b\Sberbank\VatData;
use YooKassa\Model\Payment\PaymentMethod\B2b\Sberbank\VatDataFactory;
use YooKassa\Model\Payment\PaymentMethodType;
use YooKassa\Validator\Constraints as Assert;

/**
 * Класс, представляющий модель PaymentMethodDataB2bSberbank.
 *
 * Данные для оплаты через СберБанк Бизнес Онлайн.
 *
 * @category Class
 * @package  YooKassa\Request
 * @author   cms@yoomoney.ru
 * @link     https://yookassa.ru/developers/api
 *
 * @property string $paymentPurpose Назначение платежа (не больше 210 символов).
 * @property string $payment_purpose Назначение платежа (не больше 210 символов).
 * @property VatData $vatData Данные об НДС.
 * @property VatData $vat_data Данные об НДС.
 */
class PaymentDataB2bSberbank extends AbstractPaymentData
{
    /**
     * @var string|null Назначение платежа
     */
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(min: 1)]
    #[Assert\Length(max: 210)]
    private ?string $_payment_purpose = null;

    /**
     * @var VatData|null Данные об НДС
     */
    #[Assert\NotBlank]
    #[Assert\Valid]
    #[Assert\Type(VatData::class)]
    private ?VatData $_vat_data = null;

    public function __construct(?array $data = [])
    {
        parent::__construct($data);
        $this->setType(PaymentMethodType::B2B_SBERBANK);
    }

    /**
     * Возвращает назначение платежа.
     *
     * @return string|null Назначение платежа
     */
    public function getPaymentPurpose(): ?string
    {
        return $this->_payment_purpose;
    }

    /**
     * Устанавливает назначение платежа.
     *
     * @param string|null $payment_purpose Назначение платежа
     *
     * @return self
     */
    public function setPaymentPurpose(?string $payment_purpose): self
    {
        $this->_payment_purpose = $this->validatePropertyValue('_payment_purpose', $payment_purpose);
        return $this;
    }

    /**
     * Возвращает назначение платежа.
     *
     * @return VatData|null Данные об НДС
     */
    public function getVatData(): ?VatData
    {
        return $this->_vat_data;
    }

    /**
     * Устанавливает назначение платежа.
     *
     * @param VatData|array|null $vat_data Данные об НДС
     *
     * @return self
     */
    public function setVatData(mixed $vat_data): self
    {
        if (is_array($vat_data)) {
            $vat_data = (new VatDataFactory())->factoryFromArray($vat_data);
        }
        $this->_vat_data = $this->validatePropertyValue('_vat_data', $vat_data);
        return $this;
    }
}
