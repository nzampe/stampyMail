<?php

class User {

    private $id;
    private $username;
    private $password;
    private $firstName;
    private $lastName;
    private $email;
    private $dni;
    private $createdAt;
    private $updatedAt;

    public function __construct(
        $id,
        $username, 
        $password, 
        $firstName, 
        $lastName, 
        $email, 
        $dni, 
        $createdAt, 
        $updatedAt
    )
    {
        $this->id = $id;
        $this->username = $username;
        $this->setPassword($password);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->dni = $dni;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * Getters
     */

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getlastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Setters
     */

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setlastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

}
