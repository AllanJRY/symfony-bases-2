<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    private ObjectManager $manager;
    private Generator $faker;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->faker = Factory::create('fr');
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $admin = new User();
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin
            ->setPassword($hashedPassword)
            ->setEmail('admin@admin.fr')
            ->setLastname('ADMIN')
            ->setFirstname('Admin')
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
        ;
        $this->manager->persist($admin);

        $users = $this->generateUsers();
        $categories = $this->generateCategories();
        $products = $this->generateProducts($users, $categories);
        $this->manager->flush();

    }

    private function generateUsers() : array
    {
        $newUsers = [];
        for($i = 0; $i < 5; $i++) {
            $newUser = new User();
            $hashedPassword = $this->passwordHasher->hashPassword($newUser, 'password');
            $firstname = $this->faker->firstName;
            $lastName = $this->faker->lastName;
            $email = sprintf('%s.%s@email.com', $firstname, $lastName);
            $newUser
                ->setPassword($hashedPassword)
                ->setEmail($email)
                ->setLastname($lastName)
                ->setFirstname($firstname)
                ->setRoles(['ROLE_USER'])
            ;
            $this->manager->persist($newUser);
            $newUsers[] = $newUser;
        }

        return $newUsers;
    }

    private function generateCategories() : array
    {
        $categoriesNames = ['Vêtement', 'Électronique', 'Ordinateur', 'Livre', 'Jeux'];
        $newCategories = [];
        foreach ($categoriesNames as $categoryName) {
            $newCategory = (new Category())
                ->setName($categoryName)
            ;
            $this->manager->persist($newCategory);
            $newCategories[] = $newCategory;
        }

        return $newCategories;
    }

    private function generateProducts(array $users, array $categories) : array
    {
        $newProducts = [];
        for($i = 0; $i < 5; $i++) {
            $newProduct = (new Product())
                ->setName($this->faker->words(rand(1, 5), true))
                ->setDescription($this->faker->words(rand(2, 20), true))
            ;

            $categIndexes = array_rand($categories, rand(2, 3));

            if (is_array($categIndexes)) {
                foreach ($categIndexes as $categIndex) {
                    $newProduct->addCategory($categories[$categIndex]);
                }
            } else {
                $newProduct->addCategory($categories[array_rand($categories, 1)]);
            }

            for($i = 0; $i < rand(0, 5); $i++) {
                $newProduct->addReview(
                    ( new Review() )
                        ->setAuthor($users[array_rand($users)])
                        ->setContent($this->faker->words(rand(2, 20), true))
                        ->setNote(rand(0, 10))
                );
            }

            $this->manager->persist($newProduct);
        }

        return $newProducts;
    }
}
