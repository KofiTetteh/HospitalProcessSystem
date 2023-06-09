<?php include 'php/include/head.php'; ?>
<section class="mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h2 class="h5 display">Employees List</h2>
                </div>
                <div class="card-block">
                  <table class="table table-striped table-sm">
                      <?php
                      $pays = $db->prepare('
                      SELECT payment.id, payment.aid, payment.pay, users.fullname, payment.paydate
                      FROM payment
                      INNER JOIN users ON users.id = payment.pid
                      ORDER BY paydate DESC');
                      $pays->execute();
                      $i = 0;
                      function humanTiming ($time)
                        {
                            $time = time() - $time - (3600 * 2); // to get the time since that moment
                            $time = ($time<1)? 1 : $time;
                            $tokens = array (
                                31536000 => 'year',
                                2592000 => 'month',
                                604800 => 'week',
                                86400 => 'day',
                                3600 => 'hour',
                                60 => 'minute',
                                1 => 'second'
                            );

                            foreach ($tokens as $unit => $text) {
                                if ($time < $unit) continue;
                                $numberOfUnits = floor($time / $unit);
                                return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
                            }

                        }
                       ?>

                    <thead>
                      <tr>
                        <th>id</th>
                        <th>Patient</th>
                        <th>Paid</th>
                        <th>Made by</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php while ($pay = $pays->fetch()) { $i++;
                            $ac = $db->prepare('SELECT fullname FROM users WHERE id = ?');
                            $ac->execute(array($pay['aid']));
                            $a = $ac->fetch();
                            ?>
                            <tr>
                                <th scope="row">#<?php echo $i ?></th>
                                <td><?php echo $pay['fullname'] ?></td>
                                <td><?php echo $pay['pay'] ?>Ghc</td>
                                <td><?php echo $a['fullname'] ?></td>
                                <td><?php echo humanTiming(strtotime($pay['paydate'])); ?> ago</td>
                            </tr>
                        <?php } ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>



<?php include 'php/include/footer.php'; ?>
