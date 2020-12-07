<?php


namespace BSLCore\App\Traits;

use Propaganistas\LaravelPhone\PhoneNumber;

trait ContactsTrait
{

    public function getFNameKey(): string
    {
        return 'f_name';
    }

    public function getLNameKey(): string
    {
        return 'l_name';
    }

    public function getMNameKey(): string
    {
        return 'm_name';
    }

    public function getPhoneKey(): string
    {
        return 'phone';
    }

    public function getEmailKey(): string
    {
        return 'email';
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->getFName();
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->getLName();
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->getMName();
    }

    /**
     * @return string|null
     */
    public function getFName(): ?string
    {
        return $this->{$this->getFNameKey()};
    }

    /**
     * @return string|null
     */
    public function getLName(): ?string
    {
        return $this->{$this->getLNameKey()};
    }

    /**
     * @return string|null
     */
    public function getMName(): ?string
    {
        return $this->{$this->getMNameKey()};
    }

    /**
     * @return string|null
     */
    public function getPhoneFormatted(): ?string
    {
        return self::getPhoneFromString($this->{$this->getPhoneKey()});
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->{$this->getPhoneKey()};
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        $email = $this->{$this->getEmailKey()};

        if (stripos($email, '@fake.mail') !== false) {
            $email = null;
        }

        return $email;
    }

    /**
     * @return bool
     */
    public function hasEmail(): bool
    {
        return trim($this->getEmail()) !== '';
    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function setFName(?string $value): self
    {
        return $this->setContactsField($this->getFNameKey(), $value);
    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function setLName(?string $value): self
    {
        return $this->setContactsField($this->getLNameKey(), $value);
    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function setMName(?string $value): self
    {
        return $this->setContactsField($this->getMNameKey(), $value);
    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function setEmail(?string $value): self
    {
        return $this->setContactsField($this->getEmailKey(), $value);
    }

    protected function setContactsField(string $name, ?string $value): self
    {
        $value = trim($value);
        $this->$name = $value === '' ? null : $value;
        return $this;
    }

    /**
     * @param bool $short
     *
     * @return string
     */
    public function getFullName($short = false)
    {
        $lastName = $this->getLastName();
        $middleName = $this->getMiddleName();
        $firstName = $this->getFirstName();
        if (true === $short && isset($firstName[0])) {
            $firstName = mb_substr($firstName, 0, 1, 'UTF-8') . '.';
        }

        if (true === $short && isset($middleName[0])) {
            $middleName = mb_substr($middleName, 0, 1, 'UTF-8') . '.';
        }

        $fullName = trim($lastName . ' ' . $firstName . ' ' . $middleName);
        return $fullName;
    }

    /**
     * @param string|null $phone
     * @return $this
     */
    public function setPhone(string $phone = null): self
    {
        $phoneFormatted = self::preparePhone($phone);
        return $this->setContactsField($this->getPhoneKey(), $phoneFormatted);
    }


    /**
     * @param string|null $phone
     * @param bool $formatted
     * @return string|null
     */
    public static function preparePhone(string $phone = null, bool $formatted = false): ?string
    {
        if ('' === trim($phone)) {
            $phone = null;
        }
        if (null !== $phone) {
            $phone = preg_replace('/\D/', '', $phone);
            $phoneLength = strlen($phone);

            if (10 < $phoneLength && $phoneLength < 12) {
                /**
                 * Меняем 8 на +7 в русских номерах
                 */
                $phone = mb_substr($phone, -11, 11, 'UTF-8');

                if (strpos($phone, '8') === 0) {
                    $phone[0] = 7;
                }

            } elseif (10 === $phoneLength) {
                $phone = (int)'7' . $phone;
            } elseif ($phoneLength < 10) {
                /**
                 * $phoneLength < 10
                 */
                $phone = null;
            }
        }


//        if (true === $formatted && null !== $phone) {
//            if (null !== $phone) {
//                try {
//                    $phone = (string)$phone;
//                    $phone = PhoneNumber::make($phone, ['RU', 'BE', 'UK', 'UA', 'US'])->formatInternational();
//                } catch (\Exception $exception) {
//                    Log::warning('User preparePhoneFormatted failed for "' . $phone . '" ' . $exception->getMessage());
//                }
//            }
//        }

        return $phone;
    }

    /**
     * @param string|null $phoneRaw
     * @return string|null
     */
    public static function getPhoneFromString(?string $phoneRaw): ?string
    {
        $phoneFormatted = null;
        if ($phoneRaw !== null) {

            $phoneRaw = preg_replace('/\D/', '', $phoneRaw);
            $phoneLen = strlen($phoneRaw);

//				echo $phoneLen . ' ' . $phoneRaws[$key] . ' > ';

            switch ($phoneLen) {
                case 11:
                    {
//						Приводим 7 и 8 к единому формату -> +7
                        $phoneRaw[0] = '7';
                        $phoneRaw = '+' . $phoneRaw;
                    };
                    break;

                case 10:
                    {
//						Не хватает +7
                        $phoneRaw = '+7' . $phoneRaw;
                    };
                    break;
            }

//				echo $phoneRaw . "\n";
            try {
                $phoneFormatted = PhoneNumber::make($phoneRaw)
                    ->formatInternational();
            } catch (\Exception $exception) {
//					echo $exception->getMessage() . "\n";
            }
        }

        return $phoneFormatted;
    }

    public function setAttributesContacts(array $attributes = []): void
    {
        $user = $this;
        foreach ($attributes as $name => $value) {
            switch ($name) {
                case $this->getFNameKey():
                    {
                        $user->setFName($value);
                    }
                    break;
                case $this->getLNameKey():
                    {
                        $user->setLName($value);
                    }
                    break;
                case $this->getMNameKey():
                    {
                        $user->setMName($value);
                    }
                    break;
                case $this->getPhoneKey():
                    {
                        $user->setPhone($value);
                    }
                    break;
                case $this->getEmailKey():
                    {
                        $user->setEmail($value);
                    }
                    break;


            }
        }
        $user->save();
    }
}
