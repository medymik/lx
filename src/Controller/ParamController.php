<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Country;
use App\Entity\Appelle;
use App\Entity\User;
use App\Entity\Demande;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Form\DemandeType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Product;



/*
*   @Route('dash')
*/
class ParamController extends AbstractController
{
    
    /**
     * @Route("dash/chargement/{name}", name="chargement")
     */
    public function chargement($name,ObjectManager $manager,Request $request,UserInterface $user)
    {
    	$message = '';
    	$error = '';
    	if($request->getMethod()=="POST")
    	{ 
    		
    		$code = $request->get('code'); 
    		$callid = $request->get('callid');
    		$appelle = $manager->getRepository(Appelle::class)->find($callid);
    		if($appelle){
                if($appelle->getMicropaiment()->getName()=='starpass')
                {
                    $ident=$appelle->getIdp().";;".$appelle->getIdd();
    			$codes = $code;
    			$datas='';
    			$ident=urlencode($ident);
				$codes=urlencode($codes); 
				$datas=urlencode($datas);

    			$f = file_get_contents("https://script.starpass.fr/check_php.php?ident=$ident&codes=$codes&DATAS=$datas");
                $arr = explode('|', $f);
                $cd = new \App\Entity\Code;
                $usr = $manager->getRepository(User::class)->find($user->getId());
    			if($arr){
    				if($arr[0]=='OUI')
    				{
    					$message = "Code valide !";
    					
                        $usr->setSolde($usr->getSolde()+$appelle->getPrice());
                        
                        $cd->setCode($code.' correct !');
                        $manager->persist($cd);
                        $usr->addCode($cd);
    					$manager->flush();

    				}
    				else
    				{
                        $cd->setCode($code.' incorrect !');
                        $manager->persist($cd);
                        $usr->addCode($cd);
    					$manager->flush();
    					$error = "Code incorrect !";
    				}
    			}

                }elseif($appelle->getMicropaiment()->getName()=='mypass')
                {
                    $url = 'https://www.mypass.one/api/';
                    $fields = array(
                     'key' => $appelle->getIdp(),
                        'a' => "Valid",
                     'code' => $code
                        );

                    $curl = curl_init();

                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);

                    $r = curl_exec($curl);
                    curl_close($curl);

                    $cd = new \App\Entity\Code;
                    $usr = $manager->getRepository(User::class)->find($user->getId());

                    if($r == 'CodeValide'){
                        $message = "Code valide !";
    					
                        $usr->setSolde($usr->getSolde()+$appelle->getPrice());
                        
                        $cd->setCode($code.' correct !');
                        $manager->persist($cd);
                        $usr->addCode($cd);
    					$manager->flush();
                    }
                    elseif($r == 'CodeInvalide'){

                        $cd->setCode($code.' incorrect !');
                        $manager->persist($cd);
                        $usr->addCode($cd);
    					$manager->flush();
    					$error = "Code incorrect !";
                    }
                }
            
        }
    		
    	}
    	$country = $manager->getRepository(Country::class)->findOneByName($name);
        $numbers = [];
    	if($country)
        {
            $numbers = $country->getAppelles();
        }

    	

        return $this->render('param/chargement.html.twig', [
            'numbers' => $numbers,
            'message'=>$message,
            'error' => $error
        ]);
    }

    
    
    /**
    *@Route("dash/demande",name="demande")
    */
    public function demande(Request $req,UserInterface $user,ObjectManager $manager)
    {
        $message = '';
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class,$demande);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->IsValid())
        {

            if($demande->getMontant()>=50 && $demande->getMontant()<=$user->getSolde())
            {
                $date = new \DateTime();
                $usr = $manager->getRepository(User::class)->find($user->getId());
                $usr->setSolde($usr->getSolde()-$demande->getMontant());
                $demande->setDate($date);
                $demande->setUser($usr);
                $demande->setStatus('En train de traitement !');
                $manager->persist($demande);
                $manager->flush();

                return $this->redirectToRoute('historique');
            }
            else
            {
                $message = "On peut pas traité cette demande le min est 50 € est plus !";
            }
            
        }

        return $this->render('param/demande.html.twig',
            [
                'form' => $form->createView(),
                'message'=> $message
            ]
        );
    }

     /**
    *@Route("dash/historique",name="historique")
    */
    public function history(UserInterface $user,ObjectManager $manager)
    {
       $user = $manager->getRepository(User::class)->find($user->getId());

       $demandes = $user->getDemandes();

       return $this->render('param/history.html.twig',[
        'demandes' => $demandes
       ]);

    }

    /**
    * @Route("dash/products",name="products")
    */
    public function products(ObjectManager $manager)
    {
       $products = $manager->getRepository(Product::class)->findAll();


       return $this->render('param/products.html.twig',[
        'products' => $products
       ]);

    }

    /**
    * @Route("dash/productscommande/{id?}",name="products_commander")
    */
    public function products_commande($id=null,ObjectManager $manager,UserInterface $user)
    {
        $product = null;
        if($id){
            $product = $manager->getRepository(Product::class)->find($id);
        }
       
       
       if($product && $user->getSolde()>=$product->getPrice()){
           $user->addProduct($product);
           $manager->flush();
       }


       return $this->render('param/product_commande.html.twig');

       

    }

    public function getCountries(ObjectManager $manager)
    {
        $countries = $manager->getRepository(Country::class)->findAll();
        return $this->render('param/countries.html.twig',[
            'countries' => $countries
           ]);
    }



    /**
    *@Route("dash/change-pass",name="changepass")
    */
    public function changepassword(Request $req,UserInterface $user,ObjectManager $manager,UserPasswordEncoderInterface $encoder)
    {
        $message = '';
        if($req->getMethod()=="POST")
        {
            $password = $req->get('password');
            $nvpassword = $req->get('nvpassword');
            if(!empty($password) && !empty($nvpassword))
            {
                if($password==$nvpassword){

                    
                
                        $user = $manager->getRepository(User::class)->find($user->getId());
                        $user->setPassword($encoder->encodePassword($user,$nvpassword));
                        $manager->flush();
                        $message = "Votre mot de passe à été bien changé !";


                    

                }else $message = "Les deux mot de passe sont pas identiques !";
            }else $message = "Les champs sont obligatoire !";
        }

       return $this->render('param/changepass.html.twig',[

        'message' => $message
        
       ]);

    }
}
