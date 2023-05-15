<?php
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testCreateUser()
    {
        // Création d'un utilisateur de test
        $user = new User();

        $user->setEmail('john.doe@example.com');
        $user->setPassword('password'); // Set a password

        // Persistez l'utilisateur dans la base de données
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Vérifiez que l'utilisateur a bien été persisté
        $userRepository = $this->entityManager->getRepository(User::class);
        $createdUser = $userRepository->findOneByEmail('john.doe@example.com');

        $this->assertEquals('john.doe@example.com', $createdUser->getEmail());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        // Supprimez les données de test de la base de données
        $this->entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->delete()
            ->getQuery()
            ->execute();

        $this->entityManager->close();
        $this->entityManager = null; // Évitez les fuites de mémoire
    }
}
