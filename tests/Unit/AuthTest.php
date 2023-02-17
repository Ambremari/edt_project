<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Repositories\Repository;

class AuthFormTest extends TestCase 
{
    public function setUp(): void{
        parent::setUp();
        $this->repository = new Repository();
        $this->repository->createDatabase();
    }

    public function testLoginDir(){
        $this->repository->insertDirector([
            'IdDir' => 'DIRtest', 
            'NomDir' => 'Test', 
            'PrenomDir' => 'test', 
            'MailDir' => 'test@college-vh.com',
            'MdpDir' => 'mdptest001']);
        $this->mock(Repository::class, function ($mock) {
            $mock->shouldReceive('getUserDirector')->with('DIRtest', 'mdptest001')
                                           ->once()->andReturn(['id'=>'DIRtest', 'name' => 'Test', 'firstname' => 'test']);
        });
        $response = $this->post('/login', ['id' => 'DIRtest', 'password'=>'mdptest001']);
        $response->assertStatus(302);
        $response->assertSessionHas('user', ['id'=>'DIRtest', 'name' => 'Test', 'firstname' => 'test']);
        $response->assertRedirect('/bee/saisie/enseignant');
    }

    public function testLoginDirRedirectsIfIdIsAbsent(){
        $this->repository->insertDirector([
            'IdDir' => 'DIRtest', 
            'NomDir' => 'Test', 
            'PrenomDir' => 'test', 
            'MailDir' => 'test@college-vh.com',
            'MdpDir' => 'mdptest001']);
        $response = $this->withHeader('Referer', '/login')
                         ->post('/login', ['password'=>'mdptest001']);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(["id"=>"Vous devez saisir un identifiant."]);
    }

    public function testLoginDirRedirectsIfIdDoesNotExist(){
        $this->repository->insertDirector([
            'IdDir' => 'DIRtest', 
            'NomDir' => 'Test', 
            'PrenomDir' => 'test', 
            'MailDir' => 'test@college-vh.com',
            'MdpDir' => 'mdptest001']);
        $response = $this->withHeader('Referer', '/login')
                         ->post('/login', ['id' => 'DIRnewtest', 'password'=>'mdptest001']);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(["id"=>"Cet utilisateur n'existe pas."]);
    }

    public function testDirLoginRedirectsIfPasswordIsAbsent(){
        $this->repository->insertDirector([
            'IdDir' => 'DIRtest', 
            'NomDir' => 'Test', 
            'PrenomDir' => 'test', 
            'MailDir' => 'test@college-vh.com',
            'MdpDir' => 'mdptest001']);
        $response = $this->withHeader('Referer', '/login')
                         ->post('/login', ['id' => 'DIRtest']);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(["password"=>"Vous devez saisir un mot de passe."]);
    }

    public function testLoginDirRedirectsIfPasswordIsIncorrect(){
        $this->repository->insertDirector([
            'IdDir' => 'DIRtest', 
            'NomDir' => 'Test', 
            'PrenomDir' => 'test', 
            'MailDir' => 'test@college-vh.com',
            'MdpDir' => 'mdptest001']);
        $response = $this->withHeader('Referer', '/login')
                         ->post('/login', ['id' => 'DIRtest', 'password'=>'secret256']);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testLogout() {
        $response = $this->withHeader('Referer', '/login')
                         ->withSession(['user' => ['id'=>'IDtest', 'name' => 'Test', 'firstname' => 'test']])
                         ->post('/logout');
        $response->assertStatus(302);
        $response->assertSessionMissing('user');
        $response->assertRedirect('/');
    }
}