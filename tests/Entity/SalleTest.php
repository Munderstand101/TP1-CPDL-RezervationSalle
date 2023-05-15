<?php
use App\Entity\Salle;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SalleTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testCreateSalle()
    {
        // Création d'une salle de test
        $salle = new Salle();
        $salle->setName('Salle A');

        // Persistez la salle dans la base de données
        $this->entityManager->persist($salle);
        $this->entityManager->flush();

        // Vérifiez que la salle a bien été persistée
        $salleRepository = $this->entityManager->getRepository(Salle::class);
        $createdSalle = $salleRepository->findOneByName('Salle A');

        $this->assertEquals('Salle A', $createdSalle->getName());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        // Supprimez les données de test de la base de données
        $this->entityManager->getRepository(Salle::class)->createQueryBuilder('s')
            ->delete()
            ->getQuery()
            ->execute();

        $this->entityManager->close();
        $this->entityManager = null; // Évitez les fuites de mémoire
    }
}
